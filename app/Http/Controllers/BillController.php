<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Services\EmailParserService;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    public function ekstrakDanSimpan()
    {
        set_time_limit(300);

        try {
            // --- LOGIK BARU: Tarik senarai syarikat yang dilanggan oleh user secara AKTIF ---
            $activeBillerIds = DB::table('user_billers')
                ->where('user_id', Auth::id())
                ->where('status', 'active')
                ->pluck('biller_id')
                ->toArray();

            // Kalau user belum langgan apa-apa atau semua pending, terus stop.
            if (empty($activeBillerIds)) {
                return redirect()->back()->with('info', 'You have no active biller subscriptions to sync yet.');
            }
            // ----------------------------------------------------------------------------------

            // 1. Connect to Gmail
            $client = \Webklex\IMAP\Facades\Client::account('default');
            $client->connect();
            $folder = $client->getFolder('INBOX');

            // 2. ENJIN TURBO IMAP
            $tarikhImap = now()->subDays(7)->format('d-M-Y'); 
            
            $appleMessages = $folder->query()->since($tarikhImap)->whereSubject('Apple')->get();
            $tnbMessages = $folder->query()->since($tarikhImap)->whereSubject('TNB')->get();
            $unifiMessages = $folder->query()->since($tarikhImap)->whereSubject('Unifi')->get(); 
            
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
                        $billerId = 4;
                        $data = $parser->parseAppleMusicEmail($emailBody); 
                    } 
                    elseif (str_contains($bodyLower, 'apple music')) {
                        $billerId = 2; 
                        $data = $parser->parseAppleMusicEmail($emailBody);
                    }
                }

                // C. Kategori Unifi (biller_id = 3)
                elseif (str_contains(strtolower($senderEmail), 'unifi.com.my') || str_contains(strtolower($subject), 'unifi')) {
                    $billerId = 3; 
                    
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

                // 4. SMART FILTER BARU: Pastikan billerId tu wujud dalam senarai langganan user
                if($data && isset($data['amount']) && $data['amount'] > 0 && $billerId && in_array($billerId, $activeBillerIds)) {
                    
                    $bill = \App\Models\Bill::firstOrCreate(
                        [
                            'user_id' => Auth::id(), // <-- Tukar kepada ID user yang log masuk
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