<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('price');
            $table->string('type', 100)->nullable(); //see transactionType enum
            $table->string('transaction_id', 100)->nullable();
            $table->foreignId('cheque_id')->nullable()->constrained('cheques');
            $table->foreignId('payer_id')->constrained('clients');
            $table->foreignId('receiver_id')->constrained('clients');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
