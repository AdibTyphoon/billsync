<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('linked_accounts', function (Blueprint $table) {
            $table->id('link_id'); // PK
            $table->unsignedBigInteger('user_id'); // FK
            $table->string('provider_type'); // e.g. 'gmail', 'outlook', 'imap'
            $table->string('connected_email');
            $table->string('sync_status')->default('active');
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('linked_accounts');
    }
};