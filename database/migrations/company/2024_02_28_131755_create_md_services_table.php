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
        Schema::create('md_services', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cd_company_id')->nullable()->constrained('cd_companies');

            $table->string('name'); 
            $table->text('description')->nullable();
            $table->double('price');
            
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
        Schema::dropIfExists('md_services');
    }
};
