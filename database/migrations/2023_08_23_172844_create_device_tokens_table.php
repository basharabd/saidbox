<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores' ,'id')->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained('admins' ,'id')->cascadeOnDelete();
            $table->foreignId('captains_id')->constrained('captains' ,'id')->cascadeOnDelete();
            $table->string('token');
            $table->string('device');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_tokens');
    }
}