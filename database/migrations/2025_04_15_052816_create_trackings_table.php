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

            // FK ke task
            $table->foreignId('task_id')
                ->constrained('tasks')
                ->onDelete('cascade');

            // FK ke pengepul (user)
            $table->foreignId('pengepul_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);

            // timestamp otomatis untuk catat waktu update
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trackings');
    }
}
