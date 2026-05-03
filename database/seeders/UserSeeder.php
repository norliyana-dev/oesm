<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name'      => 'Norliyana Aisyah',
            'email'     => 'norliyana@gmail.com',
            'password'  => Hash::make('abcd1234'),
        ]);
        
        $admin->assignRole('admin');

        $lecturer = User::create([
            'name'      => 'Iskandar Shah',
            'email'     => 'iskandar@utm.my',
            'password'  => Hash::make('abcd1234'),
        ]);

        $lecturer->assignRole('lecturer');

        $student = User::create([
            'name'      => 'Jenice Tan',
            'email'     => 'jenice@student.utm.my',
            'password'  => Hash::make('abcd1234'),
        ]);

        $student->assignRole('student');
    }
}
