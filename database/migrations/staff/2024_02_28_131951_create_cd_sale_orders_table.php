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
        Schema::create('cd_sale_orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cd_staff_id')->nullable()->constrained('cd_staff');
            
            $table->boolean('is_active')->default(1);
            $table->text('description')->nullable();
            $table->string('order_status_details');
            $table->string('order_status');
            $table->string('order_delay');
            
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
        Schema::dropIfExists('cd_sale_orders');
    }
};
