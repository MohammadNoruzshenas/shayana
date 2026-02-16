<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('template_settings')->insert([
            'title' => 'عنوان سایت',
            'logo' => 'logo.png',
            'keywords' => 'کلمات کلیدی سایت',
            'description' => 'توضیحات سایت',
            'about_footer' => 'test',

        ]);
    }
}
