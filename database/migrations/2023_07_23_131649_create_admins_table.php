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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('admin_name');
            $table->string('mobile_number')->unique();
            $table->date('date_of_birth');
            $table->string('id_number');
            $table->string('address');
            $table->text('description')->nullable();
            $table->integer('status')->default(0);
            $table->foreignId('city_id')->constrained('cities', 'id')->cascadeOnDelete();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};