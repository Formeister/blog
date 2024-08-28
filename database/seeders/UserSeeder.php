<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = 'asdasdasd';

        User::factory()->create([
            'name'     => 'Użytkownik',
            'email'    => 'user@example.com',
            'password' => Hash::make($password),
        ]);

        User::factory()->count(10)->create();
    }
}
