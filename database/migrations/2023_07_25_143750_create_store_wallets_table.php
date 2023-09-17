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
        Schema::create('store_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores' , 'id')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches' , 'id')->cascadeOnDelete();
            $table->decimal('total_earning' , 8 , 2);
            $table->decimal('total_withdrawal' , 8 , 2);
            $table->decimal('balance' , 8 , 2);
            $table->text('details')->nullable();
            $table->unique(['store_id', 'branch_id']);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_wallets');
    }
};