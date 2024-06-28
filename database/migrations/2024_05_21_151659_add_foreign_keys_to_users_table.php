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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('province_id', 'fk_users_to_provinces')->references('id')->on('provinces')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('regency_id', 'fk_users_to_regencies')->references('id')->on('regencies')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('district_id', 'fk_users_to_districts')->references('id')->on('districts')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('village_id', 'fk_users_to_villages')->references('id')->on('villages')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('fk_users_to_provinces');
            $table->dropForeign('fk_users_to_regencies');
            $table->dropForeign('fk_users_to_districts');
            $table->dropForeign('fk_users_to_villages');
        });
    }
};
