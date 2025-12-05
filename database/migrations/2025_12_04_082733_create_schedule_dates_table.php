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

        Schema::create('schedule_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained('schedule_workers')->cascadeOnDelete();
            $table->smallInteger('year');
            $table->tinyInteger('month');
            $table->timestamps();

            $table->unique(['worker_id', 'year', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_dates');
    }
};
