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
        Schema::create('bulk_s_m_s_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id');
            $table->json('data'); // Store Excel data as JSON
            $table->unsignedBigInteger('sms_id')->nullable(); // Reference to SMS record if needed
            $table->enum('status', ['pending', 'sent', 'failed', 'succeeded'])->default('pending');
            $table->integer('total_count')->default(0); // Total numbers in the Excel
            $table->integer('success_count')->default(0); // Successfully sent
            $table->integer('failed_count')->default(0); // Failed to send
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign keys
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sms_id')->references('id')->on('sms')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulk_s_m_s_records');
    }
};
