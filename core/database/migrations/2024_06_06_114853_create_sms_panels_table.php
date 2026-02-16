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
        Schema::create('sms_panels', function (Blueprint $table) {
            $table->id();
            $table->string('name_fa')->nullable();
            $table->string('name_en')->nullable();
            $table->string('username')->comment('username,api key')->nullable();
            $table->string('password')->comment('password,Security code')->nullable();
            $table->string('number')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_panels');
    }
};
