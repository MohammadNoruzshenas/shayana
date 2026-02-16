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
        Schema::create('tbl_secure_records', function (Blueprint $table) {
            $table->id();
            $table->string('recaptcha_site_key')->nullable();
            $table->string('recaptcha_secret_key')->nullable();

            $table->string('spot_api_key',195)->nullable();
            $table->string('mail_transport',195)->nullable();
            $table->string('mail_host',195)->nullable();
            $table->string('mail_port',195)->nullable();
            $table->string('mail_username',195)->nullable();
            $table->string('mail_password',195)->nullable();
            $table->string('mail_encyption',195)->nullable();
            $table->string('mail_from_address',195)->nullable();
            $table->string('mail_from_name',195)->nullable();
            $table->string('chat_online_key',512)->nullable();
            $table->string('site_repair_key')->nullable();
            $table->string('s3_key',195)->nullable();
            $table->string('s3_secret',195)->nullable();
            $table->string('s3_bucket',195)->nullable();
            $table->string('s3_endpoint',195)->nullable();
            $table->string('ftp_host',195)->nullable();
            $table->string('ftp_username',195)->nullable();
            $table->string('ftp_password',195)->nullable();
            $table->string('ftp_port',195)->nullable();
            $table->string('site_url',195)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_secure_records');
    }
};
