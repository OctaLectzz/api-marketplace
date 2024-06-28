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
            $table->string('invoice')->unique();
            $table->unsignedBigInteger('user_id');
            $table->double('product_price');
            $table->double('shipping_price')->nullable();
            $table->double('total_price');
            $table->string('courier')->nullable();
            $table->string('shipping_estimation')->nullable();
            $table->string('shipping_description')->nullable();
            $table->string('resi')->nullable();
            $table->string('note')->nullable();
            $table->string('snap_token')->nullable();
            $table->boolean('shipping_status')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
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
