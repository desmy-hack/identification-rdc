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
    Schema::create('citizens', function (Blueprint $table) {
        $table->id();
        $table->string('national_id')->unique();
        $table->string('last_name');
	$table->string('middle_name');
	$table->string('first_name');
        $table->date('birth_date');
        $table->string('birth_place');
        $table->enum('gender', ['M', 'F']);
        $table->string('address');
        $table->string('province');
        $table->string('territory');
        $table->string('sector');
        $table->string('phone')->nullable();
        $table->string('father_name');
        $table->string('mother_name');
        $table->string('photo')->nullable();
        $table->string('qr_code')->nullable();
        $table->foreignId('agent_id')->constrained('users')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizens');
    }
};
