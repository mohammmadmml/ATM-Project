<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Card;
use DB;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $first = Card::create(['user_id'=>'2', 'bank_id'=>'1','card_number'=>'6037997538067093','balance'=>'2000', 'password'=>bcrypt('8392')]);
        $second = Card::create(['user_id'=>'2', 'bank_id'=>'1', 'card_number'=>'6037997568452111', 'balance'=>'3000', 'password'=>bcrypt('8899')]);
        $third = Card::create(['user_id'=>'3',  'bank_id'=>'3', 'card_number'=>'5027061043850151', 'balance'=>'5000', 'password'=>bcrypt('4545')]);
        $fourth = Card::create(['user_id'=>'4', 'bank_id'=>'2', 'card_number'=>'6221211145652314', 'balance'=>'10000', 'password'=>bcrypt('7878')]);
        $fifth = Card::create(['user_id'=>'1',   'bank_id'=>'5', 'card_number'=>'6219874565124917', 'balance'=>'15000', 'password'=>bcrypt('2113')]);
    }
}
