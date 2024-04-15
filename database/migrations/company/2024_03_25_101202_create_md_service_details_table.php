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
        Schema::create('md_service_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('md_service_id')->nullable()->constrained('md_services');

            $table->text('icon');
            $table->string('service_name');
            $table->double('price');
            $table->text('description')->nullable();


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
        Schema::dropIfExists('md_service_details');
    }
};
