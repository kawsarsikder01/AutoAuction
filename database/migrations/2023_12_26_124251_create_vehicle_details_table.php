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
        Schema::create('vehicle_details', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('vehicle_type');
            $table->string('engine_type');
            $table->string('power');
            $table->string('torque');
            $table->string('displacement');
            $table->string('transmission');
            $table->string('test_result');
            $table->string('dimension');
            $table->text('short_description');
            $table->text('description');
            $table->string('price');
            $table->string('auction_time');
            $table->string('language_id');
            $table->integer('vehicle_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_details');
    }
};
