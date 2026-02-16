<?php

namespace Database\Seeders;

use App\Models\User\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(Permission::$defaultPermissions as $permission)
        {
         Permission::create($permission);
        }
    }
}
