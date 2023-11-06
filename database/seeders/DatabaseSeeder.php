<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        //Default Admin User
        DB::table('users')->insert(
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'profile' => 'suzy.jpg',
                'role' => '1',
                'phone' => '09422213057',
                'address' => 'Yangon',
                'birthday' => '1996-06-21',
                'created_user_id' => 1,
                'updated_user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
