<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Carbon\Carbon;

class CheckBillDueDates extends Command
{
    // Ini nama command untuk run di terminal nanti
    protected $signature = 'billsync:check-due';
    protected $description = 'Check for outstanding bills and send a Telegram notification 3 days before the due date.';

    public function handle()
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $today = Carbon::now()->startOfDay();
        $targetDate = Carbon::now()->addDays(3)->endOfDay();

        // Cari semua pengguna yang sudah menautkan Telegram
        $users = User::whereNotNull('telegram_chat_id')->get();
        $count = 0;

        foreach ($users as $user) {
            // Tarik tagihan yang belum dibayar berdasarkan kolom 'payment_status' = 'unpaid'
            // NOTA: Pastikan model User memiliki fungsi relationship bills()
            $dueBills = $user->bills()->where('payment_status', 'unpaid')
                             ->where('due_date', '<=', $targetDate)
                             ->get();

            if ($dueBills->isEmpty()) {
                continue;
            }

            // Format pesan peringatan 
            $message = "⚠️ *BILLSYNC REMINDER* ⚠️\n\nHi {$user->name}, you have upcoming bills due in 3 days or less:\n\n";

            foreach ($dueBills as $bill) {
                $amount = number_format($bill->amount, 2);
                $date = Carbon::parse($bill->due_date)->format('d M Y');
                
                // Menggunakan tajuk_emel sebagai nama pengenal tagihan
                $title = $bill->tajuk_emel ?? 'Unknown Bill';
                
                $message .= "🏢 Bill: {$title}\n💰 Amount: RM {$amount}\n📅 Due Date: {$date}\n\n";
            }

            $message .= "Please make your payment soon. Ignore this message if you have already paid.";

            // Kirim pesan ke Telegram
            Http::withoutVerifying()->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $user->telegram_chat_id,
                'text' => $message,
            ]);

            $count++;
        }

        $this->info("Notification successfully sent to {$count} users.");
    }
}