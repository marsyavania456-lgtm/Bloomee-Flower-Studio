<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total', 15, 2);
            // pending → approved → completed | rejected
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();         // catatan dari user
            $table->text('admin_notes')->nullable();   // catatan dari admin
            $table->string('payment_method')->default('transfer');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};