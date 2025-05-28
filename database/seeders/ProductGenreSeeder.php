<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('product_genre')->insert([
        ['product_id' => 1, 'genre_id' => 1],
        ['product_id' => 1, 'genre_id' => 2],
        ['product_id' => 1, 'genre_id' => 5],
        ['product_id' => 2, 'genre_id' => 1],
        ['product_id' => 2, 'genre_id' => 4],
        ['product_id' => 2, 'genre_id' => 3],
        ['product_id' => 3, 'genre_id' => 4],
        ['product_id' => 3, 'genre_id' => 5],
        ['product_id' => 4, 'genre_id' => 2],
        ['product_id' => 4, 'genre_id' => 4],

    ]);
    }
}
