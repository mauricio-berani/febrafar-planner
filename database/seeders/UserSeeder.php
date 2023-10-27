<?php

namespace Database\Seeders;

use App\Enums\User\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $existingUser = User::where('email', config('admin.email'))->first();
        if ($existingUser) {
            $existingUser->delete();
        }

        User::create([
            'id' => (string) Str::uuid(),
            'name' => config('admin.name'),
            'email' => config('admin.email'),
            'password' => Hash::make(config('admin.password')),
            'role' => Roles::Administrator->value
        ]);
    }
}
