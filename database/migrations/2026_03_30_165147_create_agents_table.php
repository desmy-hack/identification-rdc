<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
           
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
           
            $table->string('national_id', 11);
            $table->foreign('national_id')->references('national_id')->on('citizens')->onDelete('cascade');

            $table->string('badge_number')->unique()->nullable(); 
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};