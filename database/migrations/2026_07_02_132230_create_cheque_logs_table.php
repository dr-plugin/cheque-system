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
        Schema::create(
            'cheque_logs',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('cheque_id')->constrained('cheques');
                $table->foreignId('payer_id')->constrained('clients')->references('id');
                $table->foreignId('receiver_id')->constrained('clients')->references('id');
                $table->text('comment')->nullable('');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheque_logs');
    }
};
