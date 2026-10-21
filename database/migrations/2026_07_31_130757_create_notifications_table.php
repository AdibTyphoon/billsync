<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notification_id'); // PK
            $table->unsignedBigInteger('user_id'); // FK
            $table->unsignedBigInteger('bill_id'); // FK
            $table->text('message');
            $table->string('notification_status')->default('pending'); // 'pending', 'sent', 'failed'
            $table->timestamp('scheduled_at');
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('bill_id')->references('bill_id')->on('bills')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};