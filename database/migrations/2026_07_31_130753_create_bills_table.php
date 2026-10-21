<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id('bill_id'); // PK
            $table->unsignedBigInteger('user_id'); // FK
            $table->unsignedBigInteger('biller_id'); // FK
            $table->unsignedBigInteger('link_id')->nullable(); // FK
            $table->string('invoice_no')->nullable();
            $table->string('tajuk_emel')->nullable();
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->string('payment_status')->default('unpaid'); // 'paid', 'unpaid', 'overdue'
            $table->timestamp('extracted_at')->useCurrent();
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('biller_id')->references('biller_id')->on('billers')->onDelete('cascade');
            $table->foreign('link_id')->references('link_id')->on('linked_accounts')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};