<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CardUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('card_user')->insert([
            'card_id' => 5,
            'user_id' => 5,
            'card_name' => "Carta guay",
            'price' => 50,
            'amount' => 32
        ]);
    }
}
