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

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('worker_name');
            $table->text('schedule_data');
            $table->integer('month');
            $table->integer('year');
            $table->string('city');
            $table->string('depart');
            $table->boolean('is_active')->default(false);
            $table->string('batch_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
