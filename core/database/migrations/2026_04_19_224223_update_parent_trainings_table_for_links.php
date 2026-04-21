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
        Schema::table('parent_trainings', function (Blueprint $table) {
            $table->text('video_link')->after('description')->nullable();
            $table->text('audio_link')->after('video_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parent_trainings', function (Blueprint $table) {
            $table->dropColumn(['video_link', 'audio_link']);
        });
    }
};
