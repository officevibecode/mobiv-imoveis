<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\FeedsToken;
use App\Models\Property;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'MOBIV Admin',
            'email' => 'imoveis@grupomobiv.pt',
            'role' => UserRole::ADMIN,
            'password' => bcrypt('password'),
        ]);

        // Create 5 categories
        $categories = Category::factory(5)->create();

        // Create 12 tags
        $tags = Tag::factory(12)->create();

        // Create 50 properties with random categories and tags
        Property::factory(50)->create()->each(function ($property) use ($categories, $tags) {
            // Attach 1-3 random categories
            $property->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );

            // Attach 2-5 random tags
            $property->tags()->attach(
                $tags->random(rand(2, 5))->pluck('id')->toArray()
            );
        });

        // Create 1 demo feeds token
        FeedsToken::factory()->create([
            'name' => 'Demo Feed Token',
            'token' => hash('sha256', 'demo-token-' . now()->timestamp),
        ]);
    }
}
