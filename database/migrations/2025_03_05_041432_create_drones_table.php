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
        Schema::create('drones', function (Blueprint $table) {
            $table->id();
            $table->decimal('longitude', 10, 6);
            $table->decimal('latitude', 10, 6);
            $table->decimal('altitude', 10, 6);
            $table->decimal('ground_speed', 10, 2);
            $table->decimal('vertical_speed', 10, 2);
            $table->decimal('distance', 10, 2);
            $table->decimal('batt_volt', 5, 2);
            $table->integer('link_quality');
            $table->string('GPSSat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drones');
    }
};
