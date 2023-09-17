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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_type_id')->constrained('store_types' , 'id')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches' , 'id')->cascadeOnDelete();
            $table->foreignId('city_id')->constrained('cities', 'id')->cascadeOnDelete();
            $table->string('store_name');
            $table->string('owner_name');
            $table->text('description')->nullable();
            $table->integer('status')->default(0);
            $table->string('mobile_number')->unique();
            $table->string('image')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
