<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            
            $table->string('national_id', 11)->unique()->nullable();
            
           
            $table->string('role')->default('citizen'); 

            $table->foreign('national_id')->references('national_id')->on('citizens')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['national_id']);
            $table->dropColumn(['national_id', 'role']);
        });
    }
};