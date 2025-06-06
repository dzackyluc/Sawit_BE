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
        Schema::create('daftar_harga', function (Blueprint $table) {
            $table->id();
            $table->decimal('harga', 12, 2);
            $table->date('tanggal');
            $table->timestamps();
        });
    }        

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_harga');
    }
};
