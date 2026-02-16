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
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('payment_id')->nullable()->constrained('payments')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('payment_object')->nullable();
            $table->tinyInteger('payment_status')->default(0)->comment('0=> no payment,1 payment,2 order is back,3 => payemnt is site');
            $table->decimal('order_final_amount',20, 3)->nullable();
            $table->decimal('totalProductPrice',20, 3)->nullable();
            $table->decimal('order_discount_amount',20, 3)->nullable();
            $table->decimal('seller_share',20, 3)->nullable();
            $table->decimal('seller_site',20, 3)->nullable();
            $table->foreignId('copan_id')->nullable()->constrained('copans')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('copan_object')->nullable();
            $table->decimal('order_copan_discount_amount',20, 3)->nullable();
            $table->foreignId('common_discount_id')->nullable()->constrained('common_discount')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('common_discount_object')->nullable();
            $table->decimal('order_common_discount_amount',20, 3)->nullable();
            $table->decimal('order_total_products_discount_amount',20, 3)->nullable();
            $table->decimal('order_price',20, 3)->nullable();
            $table->tinyInteger('order_status')->default(0);
            $table->timestamps();
            $table->softDeletes();
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
