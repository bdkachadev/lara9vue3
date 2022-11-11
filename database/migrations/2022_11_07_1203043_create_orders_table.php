<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->string('notes')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('order_id')->nullable()->unique();
            $table->string('payment_transaction_id')->nullable()->unique();
            $table->bigInteger('order_subtotal');
            $table->enum('order_status', ['confirmed', 'shipped', 'pending', 'canceled', "delivered"]);
            $table->string('cart_ids');
            $table->biginteger('shipping_charge')->default(0);
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
        Schema::dropIfExists('orders');
    }
};
