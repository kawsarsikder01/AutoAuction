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
        Schema::create('plan_purchase_history', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name')->nullable();
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('price', 11, 2)->nullable();
            $table->integer('noOfListing')->nullable();
            $table->integer('noOfMaxImg')->nullable();
            $table->boolean('access_auction')->nullable();
            $table->boolean('customer_support')->nullable();
            $table->boolean('promoted_listing')->nullable();
            $table->boolean('top_search_result')->nullable();
            $table->boolean('share_other_platform')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps(); // Laravel will automatically manage created_at and updated_at timestamps
            $table->timestamp('purchase_date')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_purchase_history');
    }
};
