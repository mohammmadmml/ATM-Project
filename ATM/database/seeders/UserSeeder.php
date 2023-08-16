<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mohammad = User::create(['name'=>'mohammad','email'=>'malakouti1383@gmail.com','password' => bcrypt('83@mohammad')]);
        $sepehr = User::create(['name'=>'sepehr','email'=>'sepehr@gmail.com','password'=> bcrypt('83@sepehr')]);
        $erfan = User::create(['name'=>'erfan', 'email'=>'erfan@gmail.com','password'=>bcrypt('83@erfan')]);
        $kiarash = User::create(['name'=>'kiarash', 'email'=>'kiarash@gmail.com', 'password' => bcrypt('83@kiarash')]);
    }
}
