<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = \App\Models\Category::all();
        $tags = \App\Models\Tag::all();

        // Create 50 properties
        \App\Models\Property::factory(50)->create()->each(function ($property) use ($categories, $tags) {
            // Assign 1-2 categories based on typology
            $categoryIds = $this->getCategoriesForProperty($property, $categories);
            $property->categories()->attach($categoryIds);

            // Assign 2-5 random tags
            $tagIds = $tags->random(rand(2, 5))->pluck('id')->toArray();
            $property->tags()->attach($tagIds);
        });
    }

    private function getCategoriesForProperty($property, $categories): array
    {
        $typology = $property->typology->value;
        
        $categoryMap = [
            'T0' => ['Apartamento'],
            'T1' => ['Apartamento'],
            'T2' => ['Apartamento'],
            'T3' => ['Apartamento', 'Investimento'],
            'T4' => ['Moradia', 'Apartamento'],
            'T5' => ['Moradia'],
            'T6' => ['Moradia'],
            'terreno' => ['Terreno', 'Investimento'],
            'loja' => ['Loja/Comércio', 'Investimento'],
        ];

        $names = $categoryMap[$typology] ?? ['Apartamento'];
        $count = min(count($names), rand(1, 2));
        
        return $categories->whereIn('name', $names)
            ->take($count)
            ->pluck('id')
            ->toArray();
    }
}
