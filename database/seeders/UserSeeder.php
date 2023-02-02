<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [Str::random(6), Str::random(4), Str::random(12), Str::random(7)];
        foreach ($names as $name) {
            DB::table('users')->insert([
                'name' => $name,
                'email' => $name.'@gmail.com',
                'password' => Hash::make('1234'),
                'role' => 'Particular'
            ]);
        }
        DB::table('users')->insert([
            'name' => 'Abigail',
            'email' => 'abi@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'Profesional'
        ]);
        DB::table('users')->insert([
            'name' => 'Diego',
            'email' => 'dmorenoizq2003@gmail.com',
            'password' => Hash::make('Root'),
            'role' => 'Administrador'
        ]);
    }
}
