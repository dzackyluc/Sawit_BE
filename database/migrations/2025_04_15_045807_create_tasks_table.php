<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // foreign key ke users sebagai petani
            $table->foreignId('petani_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // foreign key ke users sebagai pengepul
            $table->foreignId('pengepul_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // status: sedang_berlangsung atau sudah_selesai
            $table->enum('status', ['sedang_berlangsung', 'sudah_selesai'])
                  ->default('sedang_berlangsung');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
}
