<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_secure_records')->insert([
            'recaptcha_site_key' => 'کلید ریکپچا',
            'recaptcha_secret_key' => 'سکرت کی ریکپچا',
            'melipayamak_username' => 'یوزرنیم ملی پیامک',
            'melipayamak_password' => ' پسورد ملی پیامک',
            'melipayamak_phone' => ' شماره ملی پیامک',

            'spot_api_key' => 'ای پی ای اسپات پلیر',
            'mail_transport' => 'mail_transport',
            'mail_host' => 'mail_host',
            'mail_port' => 'mail_port',
            'mail_username' => 'mal_username',
            'mail_password' => 'mail_password',
            'mail_encyption' => 'mail_encyption',
            'mail_from_address' => 'mail_from_address',
            'mail_from_name' => 'mail_from_name',
            'chat_online_key' => 'chat_online_key',
            'site_repair_key' => 'site_repair_key',
            's3_key' => 'key',
            's3_secret' => 'secret',
            's3_bucket' => 'bucket',
            's3_endpoint' => 'endpoint',
            'ftp_host' => 'Ftp host',
            'ftp_username' => 'Ftp username',
            'ftp_password' => 'Ftp password',
            'ftp_port' => 'Ftp port',

        ]);
    }
}
