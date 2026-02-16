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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('course_categories')->onUpdate('cascade')->onDelete('SET NULL');
            $table->text('image')->nullable();
            $table->text('video_link')->nullable();
            $table->string('percent', 5);
            $table->string('title');
            $table->string('slug');
            $table->string('price', 10);
            $table->float('priority')->nullable();
            $table->integer('maximum_registration')->nullable();
            $table->tinyInteger('get_course_option')->default(0)->comment('0 => get site , 1 => spot player ');
            $table->string('spot_api_key',195)->nullable();
            $table->string('spot_course_license',195)->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 => dont access register 1=> dar hal bargozari , 2=> tamom shode 3 tavaghof forosh');
            $table->tinyInteger('types')->default(0);
            $table->tinyInteger('progress')->comment('Course progress percentage')->default(0);
            $table->integer('sold_number')->default(0);
            $table->bigInteger('views')->default(0);
            $table->tinyInteger('course_level')->default(0)->comment('0 =>preliminary => 1 =>medium ,2=>advanced,3=>Introductory to advanced');
            $table->string('prerequisite',195)->nullable();
            $table->tinyInteger('confirmation_status')->default(0);
            $table->longText('body')->nullable();
            $table->text('summary')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
