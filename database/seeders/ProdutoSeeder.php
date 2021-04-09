<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('produtos')->insert([
            'nome' => 'Roupas',
            'preco' => 100,
            'estoque' => 4,
            'categoria_id' => 1
        ]);
        DB::table('produtos')->insert([
            'nome' => 'Calça Jeans',
            'preco' => 120,
            'estoque' => 2,
            'categoria_id' => 1
        ]);
        DB::table('produtos')->insert([
            'nome' => 'PC',
            'preco' => 3000,
            'estoque' => 3,
            'categoria_id' => 2
        ]);
        DB::table('produtos')->insert([
            'nome' => 'Impressora',
            'preco' => 250,
            'estoque' => 3,
            'categoria_id' => 5
        ]);
        DB::table('produtos')->insert([
            'nome' => 'Mouse',
            'preco' => 30,
            'estoque' => 3,
            'categoria_id' => 5
        ]);
        DB::table('produtos')->insert([
            'nome' => 'Perfume',
            'preco' => 500,
            'estoque' => 5,
            'categoria_id' => 4
        ]);

    }
}
