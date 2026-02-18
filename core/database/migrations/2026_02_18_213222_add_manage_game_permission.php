<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add manage_game permission if it doesn't exist
        if (!DB::table('permissions')->where('name', 'manage_game')->exists()) {
            DB::table('permissions')->insert([
                'name'        => 'manage_game',
                'description' => 'مدیریت بازی ها',
                'status'      => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('permissions')->where('name', 'manage_game')->delete();
    }
};
