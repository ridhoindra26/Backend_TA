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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('status');
            $table->decimal('total_price', 15, 2);
            $table->string('payment_method');
            $table->foreignId('admin_id')->constrained('admins');
            $table->foreignId('operator_id')->constrained('operators');
            $table->foreignId('drone_id')->constrained('drones');
            $table->foreignId('station_id')->constrained('stations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
