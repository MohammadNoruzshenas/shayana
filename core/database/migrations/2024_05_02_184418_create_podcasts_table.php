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
        Schema::create('podcasts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained('podcast_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('podcaster_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('image')->nullable();
            $table->text('voice')->nullable();
            $table->text('body')->nullable();
            $table->text('summary')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_vip')->default(0);
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
        Schema::dropIfExists('podcasts');
    }
};
