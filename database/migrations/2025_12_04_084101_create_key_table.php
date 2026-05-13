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

        Schema::create('keys', function (Blueprint $table) {
            $table->id();
            $table->string('device_serial')->nullable()->unique();
            $table->string('reg_number')->unique();
            $table->string('device_id')->nullable()->unique();
            $table->text('device_address');
            $table->string('district')->index();
            $table->string('color');
            $table->string('model_name')->nullable();
            $table->string('os_version')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('sim_number')->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('batch_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keys');
    }
};
