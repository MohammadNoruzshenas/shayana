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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('username', 50)->nullable();
            $table->tinyInteger('is_admin')->default(0);
            $table->string('mobile', 14)->nullable();
            $table->string('headline')->nullable();
            $table->text('bio')->nullable();
            $table->string('ip')->nullable();
            $table->string('telegram')->nullable();
            $table->string('instagram')->nullable();

            $table->text("image")->nullable();
            $table->string('cart', 16)->nullable();
            $table->string('shaba', 24)->nullable();
            $table->decimal("balance",20,3)->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->text('active_key')->nullable();
            $table->string('password');
            $table->tinyInteger('status')->default(0);

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
