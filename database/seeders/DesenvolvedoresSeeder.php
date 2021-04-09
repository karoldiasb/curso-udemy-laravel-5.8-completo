<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesenvolvedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('desenvolvedores')->insert(['nome' => 'Fulano 1', 'cargo' => 'Analista Pleno']);
        DB::table('desenvolvedores')->insert(['nome' => 'Fulano 2', 'cargo' => 'Analista Senior']);
        DB::table('desenvolvedores')->insert(['nome' => 'Fulano 3', 'cargo' => 'Programador Jr']);
    }
}
