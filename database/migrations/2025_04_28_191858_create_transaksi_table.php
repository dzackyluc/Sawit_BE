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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('petani_id');   // foreign key ke users.id
            $table->unsignedBigInteger('pengepul_id'); // foreign key ke users.id
            $table->decimal('total_harga', 15, 2);      // Total harga transaksi
            $table->timestamps();
        
            // Tambahkan foreign key constraint
            $table->foreign('petani_id')->references('id')->on('users')->onDelete('cascade');  // Hubungkan dengan ID petani
            $table->foreign('pengepul_id')->references('id')->on('users')->onDelete('cascade'); // Hubungkan dengan ID pengepul
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
