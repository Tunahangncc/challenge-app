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
        Schema::create('device_operating_systems', function (Blueprint $table) {
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('operating_system_id');

            $table->foreign('device_id')->references('id')->on('devices')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('operating_system_id')->references('id')->on('operating_systems')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_operating_systems');
    }
};
