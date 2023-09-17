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
        Schema::create('orders', function (Blueprint $table) {
          //  $table->id();
            $table->bigIncrements('id')->unique();
            $table->foreignId('store_id')->constrained('stores' , 'id')->cascadeOnDelete();
            $table->foreignId('city_id')->constrained('cities', 'id')->cascadeOnDelete();
            $table->foreignId('size_id')->constrained('sizes', 'id')->cascadeOnDelete();
            $table->foreignId('captain_id')->constrained('captains', 'id')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches' , 'id')->cascadeOnDelete();
            $table->foreignId('reason_id')->nullable()->constrained('reasons' , 'id')->onDelete('cascade');
            $table->foreignId('order_status_id')->nullable()->constrained('order_statuses' , 'id')->onDelete('cascade');
            $table->string('name');
            $table->string('mobile_number');
            $table->text('address');
            $table->string('order_type')->default('parcel');
            $table->text('order_note')->nullable();
            $table->date('request_order');
            $table->timestamps();
        });
      }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
