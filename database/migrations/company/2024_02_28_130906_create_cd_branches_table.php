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
        Schema::create('cd_branches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cd_company_id')->nullable()->constrained('cd_companies');

            
            $table->string('name');
            $table->string('country');
            $table->string('city');
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->boolean('is_active')->default(1);
            $table->text('description')->nullable();
            $table->double('latitude', 10, 6);
            $table->double('longitude', 10, 6);

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
        Schema::dropIfExists('cd_branches');
    }
};
