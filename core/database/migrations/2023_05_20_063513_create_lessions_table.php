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
        Schema::create('lessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('season_id')->constrained('seasons')->onUpdate('cascade')->onDelete('cascade')->nullable();

            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('link')->nullable();
            $table->text('file_link')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->tinyInteger('is_free')->default(0)->comment('0 -> free 1=>mony');

            $table->longText('body')->nullable();
            $table->tinyInteger('time')->unsigned()->nullable();
            $table->integer('number')->unsigned()->nullable();
            $table->tinyInteger('confirmation_status')->default(2)->comment('0 => reject','1 => accept' , '2 => pending');
            $table->tinyInteger('status')->default(0)->comment(' 0=>lock , 1 => open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessions');
    }
};
