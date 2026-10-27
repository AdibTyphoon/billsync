<?php

namespace App\Services;

use Carbon\Carbon;
use Smalot\PdfParser\Parser;

class EmailParserService
{
    // 1. Enjin Pengekstrakan TNB (Khusus untuk PDF / Teks)
    public function parseTnbEmail($content)
    {
        // Periksa sama ada content adalah PDF
        if (substr(trim($content), 0, 5) === '%PDF-') {
            $pdfParser = new Parser();
            $pdf = $pdfParser->parseContent($content);
            $text = $pdf->getText();
        } else {
            $text = $content;
        }

        // A. Ekstrak Jumlah Bil
        preg_match('/Jumlah Bil Anda \(RM\)\s+([0-9,]+\.[0-9]{2})/i', $text, $amountMatch);
        $amount = $amountMatch[1] ?? 0;
        $amount = (float) str_replace(',', '', $amount);

        // B. Ekstrak Tarikh Akhir (Due Date)
        preg_match('/Sila bayar sebelum\s+([0-9]{1,2}\s+[A-Za-z]+\s+[0-9]{4})/i', $text, $dateMatch);
        $dueDateString = $dateMatch[1] ?? null;
        
        $dueDate = null;
        if ($dueDateString) {
            $bulanMelayu = ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogo', 'Sep', 'Okt', 'Nov', 'Dis'];
            $bulanInggeris = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            
            $englishDateString = str_replace($bulanMelayu, $bulanInggeris, $dueDateString);
            
            // Guna parse() lebih selamat dari createFromFormat()
            try {
                $dueDate = Carbon::parse($englishDateString)->format('Y-m-d');
            } catch (\Exception $e) {
                $dueDate = null;
            }
        }

        return [
            'provider' => 'TNB',
            'amount' => $amount,
            'due_date' => $dueDate,
            'status' => 'unpaid'
        ];
    }

    // ---------------------------------------------------------
    // RANGKA ENJIN LAIN
    // ---------------------------------------------------------
    
// 3. Enjin Pengekstrakan Unifi (Khusus untuk PDF / Teks)
    public function parseUnifiEmail($content)
    {
        // Periksa sama ada content yang masuk adalah PDF
        if (substr(trim($content), 0, 5) === '%PDF-') {
            $pdfParser = new \Smalot\PdfParser\Parser();
            try {
                $pdf = $pdfParser->parseContent($content);
                $text = $pdf->getText();
            } catch (\Exception $e) {
                $text = $content;
            }
        } else {
            $text = $content;
        }

        // A. Ekstrak Jumlah Bil Unifi
        // Cari pola "Total Amount Payable RM 209.15" berdasarkan teks PDF
        preg_match('/Total Amount Payable\s+RM\s*([0-9,]+\.[0-9]{2})/i', $text, $amountMatch);
        $amount = $amountMatch[1] ?? 0;
        $amount = (float) str_replace(',', '', $amount);

        // B. Ekstrak Tarikh Akhir (Due Date)
        // Cari pola "Pay before 03 Nov 2026"
        preg_match('/Pay before\s+([0-9]{1,2}\s+[A-Za-z]+\s+[0-9]{4})/i', $text, $dateMatch);
        $dueDateString = $dateMatch[1] ?? null;

        $dueDate = null;
        if ($dueDateString) {
            try {
                
                $dueDate = \Carbon\Carbon::parse(trim($dueDateString))->format('Y-m-d');
            } catch (\Exception $e) {
                $dueDate = null;
            }
        }

        return [
            'provider' => 'Unifi',
            'amount' => $amount,
            'due_date' => $dueDate,
            'status' => 'unpaid' 
        ];
    }


    // 2. Enjin Apple Music 
    public function parseAppleMusicEmail($content)
    {
        // 1. Ekstrak Tarikh 
        // Tangkap tarikh selepas perkataan Renews. '/ui' jadikan regex kebal pada format unicode pelik.
        preg_match('/Renews[^a-zA-Z0-9]*([A-Za-z0-9\s,]+[0-9]{4})/ui', $content, $dateMatch);
        $dueDateString = $dateMatch[1] ?? null;

        // 2. Ekstrak Jumlah 
        // Abaikan semua benda [^0-9]* selepas RM sehinggalah terjumpa nombor.
        preg_match('/RM[^0-9]*([0-9,]+\.[0-9]{2})/ui', $content, $amountMatch);
        $amount = $amountMatch[1] ?? 0;

        $dueDate = null;
        if ($dueDateString) {
            // Bersihkan sisa spasi berganda atau koma berterabur
            $cleanDateString = trim(preg_replace('/\s+/', ' ', $dueDateString));
            
            try {
                // Carbon::parse() sangat pintar, dia boleh baca "6 Nov 2026" atau "November 6, 2026" secara automatik
                $dueDate = Carbon::parse($cleanDateString)->format('Y-m-d');
            } catch (\Exception $e) {
                $dueDate = null;
            }
        }

        return [
            'provider' => 'Apple Music',
            'amount' => (float) str_replace(',', '', $amount),
            'due_date' => $dueDate,
            'status' => 'paid' 
        ];
    }
}