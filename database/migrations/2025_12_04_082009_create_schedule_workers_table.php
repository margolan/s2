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

        Schema::create('schedule_workers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('city');
            $table->string('depart');
            $table->timestamps();

            $table->index('city');
            $table->index('depart');
            $table->index(['city', 'depart']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_workers');
    }
};
