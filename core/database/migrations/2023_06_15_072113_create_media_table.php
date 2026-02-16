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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->text('media')->nullable();
            $table->tinyInteger('type')->comment('1 => image, 2 => video, 3 => zip, 4 => audio, 5=> doc')->nullable();
            $table->string('title', 255);
            $table->tinyInteger('is_private');
            $table->string('storage_space')->comment('host,s3,ftp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
