<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeedsTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\FeedsToken::create([
            'name' => 'Demo Feed Token',
            'token' => hash('sha256', 'demo-feed-' . now()->timestamp),
        ]);
    }
}
