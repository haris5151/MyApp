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
        Schema::create('md_sizes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users');
            
            $table->string('size_name');
            $table->float('chest_width')->nullable();
            $table->float('waist_width')->nullable();
            $table->float('sleeve_length')->nullable();
            $table->float('shoulder_width')->nullable();
            $table->string('gender')->nullable();
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
        Schema::dropIfExists('md_sizes');
    }
};
