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
        Schema::create('verification_codes', function (Blueprint $table) {

             $table->id();
             $table->string('phone')->unique();
             $table->integer('code');

             // Relationship with stores table
             $table->foreign('phone')->unique()->references('mobile_number')->on('stores')->onDelete('cascade')->name('verification_codes_store_phone_foreign');

             // Relationship with captains table
             $table->foreign('phone')->unique()->references('mobile_number')->on('captains')->onDelete('cascade')->name('verification_codes_captain_phone_foreign');

            // Relationship with captains table
            $table->foreign('phone')->unique()->references('mobile_number')->on('admins')->onDelete('cascade')->name('verification_codes_admin_phone_foreign');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_codes');
    }
};