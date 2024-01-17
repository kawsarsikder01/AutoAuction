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
        Schema::create('report_conversation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('reporter_id');
            $table->unsignedBigInteger('reported_id');
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('report_id');
            $table->text('message');
            $table->timestamps();
            $table->foreign('reporter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reported_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_conversation');
    }
};
