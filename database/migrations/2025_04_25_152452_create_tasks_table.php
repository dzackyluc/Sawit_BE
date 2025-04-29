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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
        
            // FK ke janji_temu
            $table->foreignId('janji_temu_id')
                ->constrained('janji_temu')
                ->onDelete('cascade');
        
            // FK ke users sebagai pengepul
            $table->foreignId('pengepul_id')
                ->constrained('users')
                ->onDelete('cascade');
        
            // status assignment pengepul
            $table->enum('status', [
                'pending',          
                'accepted',         
                'rejected',         
                'in_progress',      
                'completed',        
            ])->default('pending');
        
            $table->timestamps();
        });   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
