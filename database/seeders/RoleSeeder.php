<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $studentRole = Role::create(['name' => 'student']);

        Permission::create(['name' => 'manage courses']);
        Permission::create(['name' => 'manage students']);
        Permission::create(['name' => 'manage training schedules']);
        Permission::create(['name' => 'enroll in training']);

        $adminRole->givePermissionTo(['manage courses', 'manage students', 'manage training schedules']);
        $studentRole->givePermissionTo(['enroll in training']);
    }
}
