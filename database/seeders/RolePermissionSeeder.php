<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // membuat beberapa role
        $teacherRole = Role::create([
            'name' => 'teacher',
        ]);

        $studentRole = Role::create([
            'name' => 'student',
        ]);

        $ownerRole = Role::create([
            'name' => 'owner',
        ]);

        // membuat default akun superadmin untuk mengelola data awal
        $userOwner = User::create([
            'name' => 'Rangga Dwi',
            'occupation' => 'Engineer',
            'avatar' => 'images/default-avatar.png',
            'email' => 'rangga100@gmail.com',
            'password' => bcrypt('123123123'),
        ]);

        $userOwner->assignRole($ownerRole);
    }
}
