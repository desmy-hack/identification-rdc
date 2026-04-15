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
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        $table->string('national_id', 15)->unique(); 
        $table->string('qr_code')->nullable();       
        $table->string('last_name');
        $table->string('middle_name')->nullable();
        $table->string('first_name');
        $table->string('email')->unique(); 
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
        $table->string('health_record_number')->nullable();   
        $table->string('criminal_record_number')->nullable(); 
        $table->string('social_security_number')->nullable(); 
        $table->string('tax_id_number')->nullable();          
        $table->string('student_card_number')->nullable();    
        $table->string('passport_number')->nullable();        
        $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('set null');
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
