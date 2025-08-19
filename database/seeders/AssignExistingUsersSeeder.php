<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AssignExistingUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan role student ada
        $studentRole = Role::where('name', 'student')->first();

        if (!$studentRole) {
            $this->command->error('Student role not found! Please run RolePermissionSeeder first.');
            return;
        }

        // Ambil semua user yang belum punya role
        $usersWithoutRoles = User::whereDoesntHave('roles')->get();

        $this->command->info("Found {$usersWithoutRoles->count()} users without roles");

        foreach ($usersWithoutRoles as $user) {
            // Skip jika user adalah owner berdasarkan email
            if ($user->email === 'rangga100@gmail.com') {
                $user->assignRole('owner');
                $this->command->info("Assigned owner role to: {$user->email}");
            } else {
                $user->assignRole('student');
                $this->command->info("Assigned student role to: {$user->email}");
            }
        }

        $this->command->info('Finished assigning roles to existing users');
    }
}
