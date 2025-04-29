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
        
            // FK ke users sebagai petani
            $table->foreignId('petani_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->string('alamat');
            $table->string('no_hp');
            $table->timestamp('tanggal');
            $table->decimal('petani_lat', 10, 7)->nullable();
            $table->decimal('petani_lng', 10, 7)->nullable();
            $table->enum('status', ['pending','approved','rejected'])
                ->default('pending');
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
