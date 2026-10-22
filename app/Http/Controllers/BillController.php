<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Services\EmailParserService;
use Webklex\IMAP\Facades\Client;

class BillController extends Controller
{
    public function ekstrakDanSimpan()
    {
        // Bagi masa lebih sikit, tapi lepas ni takkan guna sampai 300 saat dah
        set_time_limit(300);

        try {
            // 1. Connect to Gmail
            $client = \Webklex\IMAP\Facades\Client::account('default');
            $client->connect();
            $folder = $client->getFolder('INBOX');

            // ==========================================
            // 2. ENJIN TURBO IMAP (MEMPERCEPATKAN SYNC)
            // ==========================================
            // Tarikh undur 7 hari supaya lebih selamat
            $tarikhImap = now()->subDays(7)->format('d-M-Y'); 
            
            // Suruh server Google carikan tajuk yang ada "Apple" dan "TNB" sahaja. 
            // Tak payah download emel sampah yang lain!
            $appleMessages = $folder->query()->since($tarikhImap)->whereSubject('Apple')->get();
            $tnbMessages = $folder->query()->since($tarikhImap)->whereSubject('TNB')->get();
            $unifiMessages = $folder->query()->since($tarikhImap)->whereSubject('Unifi')->get(); 
            
            // Gabungkan kedua-dua hasil menjadi 1 list (Sekarang sistem cuma ada 1-5 emel penting sahaja)
            $messages = $appleMessages->merge($tnbMessages)->merge($unifiMessages); 

            $parser = new \App\Services\EmailParserService();
            $savedBills = [];

            // 3. Read and parse emails
            foreach($messages as $message){
                $subject = mb_decode_mimeheader((string) $message->getSubject());
                $senderEmail = $message->getFrom()[0]->mail ?? ''; 
                
                $data = null; 
                $billerId = null;

                // === PEGAWAI TRAFIK BERMULA DI SINI ===
                
                // A. Kategori TNB (biller_id = 1)
                if (str_contains(strtolower($senderEmail), 'tnb.com.my') || str_contains(strtolower($subject), 'tnb')) {
                    $billerId = 1; 
                    
                    if($message->hasAttachments()){
                        $attachments = $message->getAttachments();
                        foreach($attachments as $attachment){
                            if(strtolower($attachment->getExtension()) == 'pdf'){
                                $data = $parser->parseTnbEmail($attachment->getContent()); 
                                break; 
                            }
                        }
                    } else {
                        $data = $parser->parseTnbEmail($message->getTextBody());
                    }
                }
                
            // B. Kategori Ekosistem Apple (Apple Music = ID 2, iCloud = ID 4)
                elseif (str_contains(strtolower($senderEmail), 'apple.com') || str_contains(strtolower($subject), 'apple')) {
                    
                    $rawHtml = $message->getHTMLBody();
                    $cleanHtml = html_entity_decode(strip_tags(str_replace(['<br>', '<br/>', '</div>', '</p>', '</tr>', '</td>'], " \n ", $rawHtml)));
                    $rawText = $message->getTextBody();
                    
                    $emailBody = $cleanHtml . " \n " . $rawText; 
                    $bodyLower = strtolower($emailBody);
                    
                    // PEGAWAI TRAFIK CHECK ISI DALAM: iCloud atau Music?
                    if (str_contains($bodyLower, 'icloud')) {
                        $billerId = 4; // Campak ke laci iCloud
                        $data = $parser->parseAppleMusicEmail($emailBody); // Guna enjin sama sebab susunan resit sebiji
                    } 
                    elseif (str_contains($bodyLower, 'apple music')) {
                        $billerId = 2; // Campak ke laci Apple Music
                        $data = $parser->parseAppleMusicEmail($emailBody);
                    }
                }

                // C. Kategori Unifi (biller_id = 3)
                elseif (str_contains(strtolower($senderEmail), 'unifi.com.my') || str_contains(strtolower($subject), 'unifi')) {
                    $billerId = 3; // Pastikan ID 3 ni adalah Unifi dalam table billers kau
                    
                    if($message->hasAttachments()){
                        $attachments = $message->getAttachments();
                        foreach($attachments as $attachment){
                            if(strtolower($attachment->getExtension()) == 'pdf'){
                                $data = $parser->parseUnifiEmail($attachment->getContent()); 
                                break; 
                            }
                        }
                    } else {
                        $data = $parser->parseUnifiEmail($message->getTextBody());
                    }
                }
                
                // =====================================

                // 4. SMART FILTER: Simpan kalau ada data, jumlah wujud, dan billerId wujud
                if($data && isset($data['amount']) && $data['amount'] > 0 && $billerId) {
                    
                    $bill = \App\Models\Bill::firstOrCreate(
                        [
                            'user_id' => 1,
                            'biller_id' => $billerId, 
                            'amount' => $data['amount'],
                            'due_date' => $data['due_date'],
                        ],
                        [
                            'tajuk_emel' => $subject,
                            'payment_status' => $data['status'] ?? 'unpaid'
                        ]
                    );

                    if ($bill->wasRecentlyCreated) {
                        $savedBills[] = $bill;
                    }
                }
            }

            // 6. FINAL RESULT
            if(count($savedBills) > 0) {
                return redirect()->back()->with('success', 'Sync successful! New bills have been added to your dashboard.');
            } else {
                return redirect()->back()->with('info', 'Your dashboard is already up to date. No new bills found.');
            }

        } catch (\Exception $e) {
            dd('SISTEM SANGKUT SEBAB: ' . $e->getMessage()); 
        }
    }
}