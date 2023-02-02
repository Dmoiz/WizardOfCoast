<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CardSeeder extends Seeder
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
            DB::table('cards')->insert([
                'name' => $name,
                'description' => $name,
                'collection_id' => 1
            ]);
        }
    }
}
