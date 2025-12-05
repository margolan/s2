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

        Schema::create('schedule_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('date_id')->constrained('schedule_dates')->cascadeOnDelete();
            $table->tinyInteger('day');
            $table->string('status', 10);
            $table->timestamps();

            $table->unique(['date_id', 'day']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_days');
    }
};
