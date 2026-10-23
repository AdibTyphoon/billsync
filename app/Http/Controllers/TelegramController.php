<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TelegramController extends Controller
{
    public function sync()
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        
        // Tarik data mesej terbaru dari Telegram
        $response = Http::withoutVerifying()->get("https://api.telegram.org/bot{$token}/getUpdates");

        if ($response->successful()) {
            $updates = $response->json()['result'];
            $userId = Auth::id();

            foreach ($updates as $update) {
                if (isset($update['message']['text'])) {
                    $text = $update['message']['text'];
                    $chatId = $update['message']['chat']['id'];

                    // Sistem akan cari mesej yang ada command "/start [user_id]"
                    if (str_starts_with($text, '/start ' . $userId)) {
                        $user = User::find($userId);
                        $user->telegram_chat_id = $chatId;
                        $user->save();

                        return back()->with('success', 'Telegram successfully linked!');
                    }
                }
            }
            return back()->with('error', 'Please click START in Telegram first before clicking Sync.');
        }

        return back()->with('error', 'Failed to connect to Telegram server.');
    }

    public function testMessage()
    {
        $user = Auth::user();
        $token = env('TELEGRAM_BOT_TOKEN');
        
        // Format the message in English
        $message = "🎉 Success! BillSync is now officially connected to your Telegram, {$user->name}.\n\nYou will start receiving bill due date notifications right here.";

        // Send request to Telegram API
        $response = Http::withoutVerifying()->post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $user->telegram_chat_id,
            'text' => $message,
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Test message successfully sent to Telegram!');
        }

        return back()->with('error', 'Failed to send message to Telegram.');
    }
}