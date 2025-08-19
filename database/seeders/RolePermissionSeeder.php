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
        // Membuat beberapa role
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);

        // Membuat default akun superadmin untuk mengelola data awal
        $userOwner = User::firstOrCreate(
            ['email' => 'rangga100@gmail.com'],
            [
                'name' => 'Rangga Dwi',
                'occupation' => 'Engineer',
                'avatar' => 'images/default-avatar.png',
                'password' => bcrypt('password'),
            ]
        );

        // Sync role owner (hapus semua role lama, assign owner)
        $userOwner->syncRoles(['owner']);

        // Assign role student ke semua user yang belum punya role
        $usersWithoutRoles = User::whereDoesntHave('roles')->get();
        foreach ($usersWithoutRoles as $user) {
            // Skip user owner
            if ($user->id !== $userOwner->id) {
                $user->assignRole($studentRole);
            }
        }
    }
}
