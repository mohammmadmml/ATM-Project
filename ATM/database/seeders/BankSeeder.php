<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bank;
use DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meli = Bank::create(['name'=>'meli', 'code'=>'6037']);
        $pasargad = Bank::create(['name'=>'pasargad', 'code'=>'5022']);
        $shahr = Bank::create(['name'=>'shahr','code'=>'5027']);
        $parsian = Bank::create(['name'=>'parsian','code'=>'6221']);
        $saman = Bank::create(['name'=>'saman','code'=>'6219']);
    }
}
