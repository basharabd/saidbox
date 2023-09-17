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
        Schema::create('order_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders', 'id')->cascadeOnDelete();
            $table->decimal('admin_collect' , 8 , 2);
            $table->decimal('store_collect' , 8 , 2);
            $table->decimal('delivery_collect' , 8 , 2);
            $table->decimal('order_price', 8, 2);
            $table->integer('package')->default(1);
            $table->enum('delivery_fees',['store' , 'admin' , 'customer'])->default('store');
            $table->decimal('fees', 8, 2)->default(0);
            $table->decimal('subtotal', 8, 2)->default(0);
            $table->decimal('total', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_transactions');
    }
};
