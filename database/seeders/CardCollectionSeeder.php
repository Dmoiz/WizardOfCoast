<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CardCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 5; $i++) {
            if($i % 2 == 0) {
                DB::table('card_collection')->insert([
                    'card_id' => $i,
                    'collection_id' => 2
                ]);
            } else {
                DB::table('card_collection')->insert([
                    'card_id' => $i,
                    'collection_id' => 1
                ]);
            }
        }
    }
}
