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
        Schema::create('template_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('logo')->nullable();
            $table->text('image_auth')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('about_footer')->nullable();
            $table->string('copyright',195)->nullable();
            $table->string('title_site_index',195)->nullable();
            $table->string('description_site_index')->nullable();
            $table->string('sticky_banner',195)->nullable();
            $table->text('link_instagram')->nullable();
            $table->text('link_telegram')->nullable();
            $table->string('main_color','195')->default('230 99 71');
            $table->string('secondary_color','195')->default('210 60 14');
            $table->string('dark_color','195')->default('210 53 18');
            $table->string('white_color','195')->default('0 0 100');
            $table->tinyInteger('show_students')->default(0)->comment('0=> dont can see number students for course , 1=> can access see number students');
            $table->tinyInteger('show_social_user')->default(0)->comment('0=>disable 1=> enable');
            $table->tinyInteger('show_rate')->default(1)->comment('0=>disable 1=> enable');
            $table->tinyInteger('show_info')->default(1)->comment('0=>disable 1=> enable');
            $table->tinyInteger('show_comments_index')->default(1)->comment('0=>disable 1=> enable');
            $table->tinyInteger('show_vipPost_index')->default(1)->comment('0=>disable 1=> enable');
            $table->tinyInteger('show_courseFree_index')->default(1)->comment('0=>disable 1=> enable');
            $table->tinyInteger('show_plan_index')->default(1)->comment('0=>disable 1=> enable');
            $table->text('icon_html')->nullable();
            $table->tinyInteger('number_post_page')->default(12);
            $table->tinyInteger('number_course_page')->default(12);
            $table->text('description_plan_index')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_settings');
    }
};
