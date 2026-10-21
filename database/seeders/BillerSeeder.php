<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Biller;

class BillerSeeder extends Seeder
{
    public function run(): void
    {
        $billers = [
            [
                'biller_name' => 'TNB (Tenaga Nasional Berhad)',
                'category' => 'Utility',
                'sender_email' => 'no-reply@tnb.com.my',
                'status' => 'active'
            ],
            [
                'biller_name' => 'Unifi / CelcomDigi',
                'category' => 'Telco',
                'sender_email' => 'e-bill@unifi.com.my',
                'status' => 'active'
            ],
            [
                'biller_name' => 'Netflix',
                'category' => 'Subscription',
                'sender_email' => 'info@account.netflix.com',
                'status' => 'active'
            ],
            [
                'biller_name' => 'Spotify',
                'category' => 'Subscription',
                'sender_email' => 'no-reply@spotify.com',
                'status' => 'active'
            ],
        ];

        foreach ($billers as $biller) {
            Biller::create($biller);
        }
    }
}