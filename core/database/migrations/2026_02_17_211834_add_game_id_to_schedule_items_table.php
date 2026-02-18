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
        Schema::table('schedule_items', function (Blueprint $table) {
            $table->foreignId('game_id')->nullable()->after('lession_id')->constrained('games')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_items', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['game_id_foreign']);
            $table->dropColumn('game_id');
        });
    }
};
