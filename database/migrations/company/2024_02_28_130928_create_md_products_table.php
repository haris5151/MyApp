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
        Schema::create('md_products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cd_company_id')->nullable()->constrained('cd_companies');
            $table->foreignId('cd_branch_id')->nullable()->constrained('cd_branches');


            $table->string('name');
            $table->double('price');
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('md_products');
    }
};
