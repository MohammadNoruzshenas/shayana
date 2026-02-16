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
        Schema::create('schedule_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weekly_schedule_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('day_of_week')->comment('0: Saturday, 1: Sunday, 2: Monday, 3: Tuesday, 4: Wednesday, 5: Thursday, 6: Friday');
            $table->tinyInteger('time_slot')->comment('1: Slot 1, 2: Slot 2, 3: Slot 3, 4: Slot 4');
            $table->foreignId('lession_id')->nullable()->constrained('lessions')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['weekly_schedule_id', 'day_of_week', 'time_slot']);
            $table->index(['weekly_schedule_id', 'day_of_week']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_items');
    }
};
