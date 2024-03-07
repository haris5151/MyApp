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
        Schema::create('cd_staff', function (Blueprint $table) {
            $table->id();

            $table->foreignId('td_order_id')->nullable()->constrained('td_orders');
            $table->foreignId('td_order_detail_id')->nullable()->constrained('td_order_details');

            $table->boolean('is_active')->default(1);
            $table->string('name');
            $table->string('phone_number');
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
        Schema::dropIfExists('cd_staff');
    }
};
