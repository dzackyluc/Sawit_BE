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
        Schema::create('janji_temu', function (Blueprint $table) {
            $table->id();
            $table->string('nama_petani');
            $table->string('email');
            $table->string('alamat');
            $table->string('no_hp');
            $table->dateTime('tanggal');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->enum('status', ['pending','approved','rejected'])
                ->default('pending');
            $table->text('alasan_reject')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('janji_temu');
        
    }
};
