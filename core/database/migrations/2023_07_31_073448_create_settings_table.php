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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('can_request_settlements')->default(0);
            $table->tinyInteger('account_confirmation')->default(0)->comment('if 0 => no Email confirmation for register 1=> need to Email confirmation');
            $table->tinyInteger('site_repair')->default(0)->comment('0=> false , 1=> true');
            $table->tinyText('defult_uploader_private')->nullable()->comment('local,ftp,s3');
            $table->tinyText('defult_uploader_public')->nullable()->comment('local,ftp');
            $table->tinyInteger('can_send_ticket')->default(0)->comment('0 => not access send tickets , 1 => can send tickets ');
            $table->tinyInteger('comment_default_approved')->default(0);
            $table->tinyInteger('stop_selling')->default(0)->comment('0=> dont sell course , 1=> can sell course');
            $table->tinyInteger('settlement_pay_time')->default(3);
            $table->decimal('minimum_deposit_request',20,3)->default(100000);
            $table->tinyInteger('can_register_user')->default(0)->comment('0 => dont access reister in site, 1 => can register site');
            $table->tinyInteger('chat_online')->default(0)->comment('0 => disable, 1=>enable chat');
            $table->tinyInteger('commentable')->default(0);
            $table->tinyInteger('recaptcha')->nullable()->comment('0 => disable recapcha google , 1=> ok');
            $table->tinyInteger('method_login_register')->default(0)->comment('0 email and mobile,1 just email,2 just mobile');
            $table->text('upload_file_format')->nullable()->comment('access format for upload file');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
