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
        Schema::create('md_expenses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('td_purchase_id')->nullable()->constrained('td_purchases');
            $table->foreignId('td_purchase_detail_id')->nullable()->constrained('td_purchase_details');

            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('md_expenses');
    }
};
