<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('national_id')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('photo')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
    	Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['national_id', 'phone', 'address', 'photo']);
        });
    }
};
