<?php

// database/migrations/xxxx_xx_xx_create_trackings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingsTable extends Migration
{
    public function up(): void
    {
        Schema::create('trackings', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('task_id')
                ->constrained('tasks')
                ->onDelete('cascade');
        
            $table->foreignId('pengepul_id')
                ->constrained('users')
                ->onDelete('cascade');
        
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
        
            // timestamps() otomatis catat waktu update → gunakan untuk timeline
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('trackings');
    }
}
