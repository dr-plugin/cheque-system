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

            $table->foreignId('owner')->constrained('clients'); //or $table->foreign('owner')->references('id')->on('clients');

            $table->string('price');
            $table->string('sayadi_number', 100)->unique();
            $table->boolean('is_registered')->default(true);

            $table->string('exporter', 200)->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank', 100)->nullable();
            $table->string('img_url')->nullable();

            $table->string('status', 100);
            $table->string('type', 100); //paper, digital

            $table->date('due_date')->nullable();

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
