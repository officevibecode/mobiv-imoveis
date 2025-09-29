<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Apartamento', 'slug' => 'apartamento'],
            ['name' => 'Moradia', 'slug' => 'moradia'],
            ['name' => 'Terreno', 'slug' => 'terreno'],
            ['name' => 'Loja/Comércio', 'slug' => 'loja-comercio'],
            ['name' => 'Investimento', 'slug' => 'investimento'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
