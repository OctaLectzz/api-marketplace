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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('avatar');
            $table->string('username')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['Customer', 'Mitra', 'Admin']);
            $table->string('phone_number')->nullable();
            $table->char('province_id')->nullable()->index('fk_users_to_provinces');
            $table->char('regency_id')->nullable()->index('fk_users_to_regencies');
            $table->char('district_id')->nullable()->index('fk_users_to_districts');
            $table->char('village_id')->nullable()->index('fk_users_to_villages');
            $table->string('country')->nullable();
            $table->integer('zip_code')->nullable();
            $table->text('address_one')->nullable();
            $table->text('address_two')->nullable();
            $table->string('store_name')->nullable();
            $table->string('category')->nullable();
            $table->integer('store_status')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
