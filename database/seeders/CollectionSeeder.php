<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [Str::random(6), Str::random(4)];
        foreach ($names as $name) {
            DB::table('collections')->insert([
                'name' => $name,
                'symbol' => $name.'png',
                'release_date' => '2000-01-01' //AÑO, MES, DÍA -- YYYY-MM-DD
            ]);
        }
    }
}
