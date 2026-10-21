<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('billers', function (Blueprint $table) {
            $table->id('biller_id'); // PK
            $table->string('biller_name'); // e.g. TNB, Unifi, Netflix, Spotify
            $table->string('category'); // e.g. Utility, Subscription, Telco
            $table->string('sender_email'); // e.g. no-reply@tnb.com.my
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billers');
    }
};