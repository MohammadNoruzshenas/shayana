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
        // اضافه کردن order column اگر وجود ندارد
        if (!Schema::hasColumn('parent_trainings', 'order')) {
            Schema::table('parent_trainings', function (Blueprint $table) {
                $table->integer('order')->default(0)->after('description');
            });
        }

        // ایجاد یک default chapter برای parent_trainings موجود
        if (Schema::hasTable('parent_training_seasons')) {
            if (\DB::table('parent_training_seasons')->count() === 0) {
                \DB::table('parent_training_seasons')->insert([
                    'title' => 'فصل پیش‌فرض',
                    'description' => 'فصل پیش‌فرض برای آموزش‌های موجود',
                    'order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // اضافه کردن season_id FK
        if (!Schema::hasColumn('parent_trainings', 'season_id')) {
            Schema::table('parent_trainings', function (Blueprint $table) {
                $table->unsignedBigInteger('season_id')->default(1)->after('id');
                $table->foreign('season_id')
                    ->references('id')
                    ->on('parent_training_seasons')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('parent_trainings', 'season_id')) {
            Schema::table('parent_trainings', function (Blueprint $table) {
                $table->dropForeign(['season_id']);
                $table->dropColumn('season_id');
            });
        }
        
        if (Schema::hasColumn('parent_trainings', 'order')) {
            Schema::table('parent_trainings', function (Blueprint $table) {
                $table->dropColumn('order');
            });
        }
    }
};
