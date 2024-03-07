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
        Schema::create('cd_user_profiles', function (Blueprint $table) {
            $table->id();

            $table->string('user_name');
            $table->string('phone_number')->nullable();
            $table->string('Email')->unique(); 
            $table->string('Rating')->nullable(); 
            $table->string('Image')->nullable();
            
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cd_user_profiles');
    }
};
