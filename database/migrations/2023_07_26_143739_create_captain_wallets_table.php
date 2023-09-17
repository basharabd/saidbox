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
        Schema::create('captain_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('captain_id')->constrained('captains', 'id')->cascadeOnDelete();
            $table->decimal('total_earning' , 8 , 2);
            $table->decimal('total_withdrawal' , 8 , 2);
            $table->decimal('balance' , 8 , 2);
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('captain_wallets');
    }
};