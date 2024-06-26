<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // $table->foreignId('cd_country_id')->nullable()->constrained('cd_countries');
            // $table->foreignId('cd_state_id')->nullable()->constrained('cd_states');
            // $table->foreignId('cd_city_id')->nullable()->constrained('cd_cities');
            // $table->foreignId('cd_role_id')->nullable()->constrained('cd_roles');
            
            $table->string('user_name');
            $table->string('country');
            $table->string('city');
            $table->double('latitude', 10, 6);
            $table->double('longitude', 10, 6);
            $table->string('image');
            $table->string('phone_number')->unique()->nullable();
            $table->string('facebook_id')->nullable()->unique();
            $table->enum('type', ['vendor', 'customer'])->default('customer');
            $table->boolean('is_active')->default(1);
            $table->text('description')->nullable();
            $table->string('email')->unique();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('address')->nullable();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

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
        Schema::dropIfExists('users');
    }
};
