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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('author_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('post_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->text('image');
            $table->longText('body');
            $table->text('summary');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_vip')->default(0);
            $table->integer('limit_body')->nullable()->comment('if post is_vip = true you can limit body for they dont access post	');
            $table->tinyInteger('confirmation_status')->default(2)->comment('0 => reject , 1=>acctepts 2=> pendding');
            $table->timestamp('published_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
