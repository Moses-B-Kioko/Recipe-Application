<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123'),
            'phone' => '123-456-7890', // Add the phone field
        ]);
    
        User::create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => Hash::make('password456'),
            'phone' => '098-765-4321', // Add the phone field
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123'),
            'phone' => '123-456-7890', // Add the phone field
        ]);
    
        User::create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => Hash::make('password456'),
            'phone' => '098-765-4321', // Add the phone field
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123'),
            'phone' => '123-456-7890', // Add the phone field
        ]);
    
        User::create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => Hash::make('password456'),
            'phone' => '098-765-4321', // Add the phone field
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123'),
            'phone' => '123-456-7890', // Add the phone field
        ]);
    
        User::create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => Hash::make('password456'),
            'phone' => '098-765-4321', // Add the phone field
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123'),
            'phone' => '123-456-7890', // Add the phone field
        ]);
    
        User::create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => Hash::make('password456'),
            'phone' => '098-765-4321', // Add the phone field
        ]);
    }
}
