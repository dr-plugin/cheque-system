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
        Schema::create('cheques', function (Blueprint $table) {

            $table->id();
            $table->string('price');
            $table->string('sayadi_number', 100)->unique();
            $table->string('exporter', 200);
            $table->string('account_number')->nullable();
            $table->string('bank', 100); //See bank
            $table->string('img_url')->nullable();
            $table->date('due_date')->nullable();
            $table->string('status', 100);
            $table->foreignId('owner')->constrained('clients'); //or $table->foreign('owner')->references('id')->on('clients');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheque');
    }
};
