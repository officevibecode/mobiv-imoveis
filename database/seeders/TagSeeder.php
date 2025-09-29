<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'Vista Mar', 'slug' => 'vista-mar'],
            ['name' => 'Pronto a Habitar', 'slug' => 'pronto-a-habitar'],
            ['name' => 'Remodelado', 'slug' => 'remodelado'],
            ['name' => 'Garagem', 'slug' => 'garagem'],
            ['name' => 'Jardim', 'slug' => 'jardim'],
            ['name' => 'Terraço', 'slug' => 'terraco'],
            ['name' => 'Elevador', 'slug' => 'elevador'],
            ['name' => 'Centro', 'slug' => 'centro'],
            ['name' => 'Bons Acessos', 'slug' => 'bons-acessos'],
            ['name' => 'Arrendamento', 'slug' => 'arrendamento'],
            ['name' => 'Oportunidade', 'slug' => 'oportunidade'],
            ['name' => 'Luxo', 'slug' => 'luxo'],
        ];

        foreach ($tags as $tag) {
            \App\Models\Tag::create($tag);
        }
    }
}
