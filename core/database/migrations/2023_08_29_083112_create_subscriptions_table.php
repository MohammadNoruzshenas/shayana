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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('plans')->onUpdate('cascade')->onDelete('cascade');
            $table->text('plan_object');
            $table->timestamp('expirydate');
            $table->tinyInteger('status')->default(0);
            $table->foreignId('payment_id')->nullable()->constrained('payments')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('payment_object')->nullable();
            $table->tinyInteger('payment_status')->default(0)->comment('0=> no payment,1 payment,2 order is back,3 => payemnt is site');
            $table->decimal('price',20, 3)->nullable();
            $table->decimal('order_final_amount',20, 3)->nullable();
            $table->decimal('order_discount_amount',20, 3)->nullable();
            $table->longText('common_discount_object')->nullable();
            $table->foreignId('copan_id')->nullable()->constrained('copans')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('copan_object')->nullable();
            $table->decimal('order_copan_discount_amount',20, 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
