<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        User::factory()->create([
            'name' => 'Admin POS',
            'email' => 'admin@local.test',
            'password' => bcrypt('Password123!'),
        ]);

        // 2. Create Categories
        $actionFiguresCategory = Category::create([
            'name' => 'Action Figures',
            'code' => Str::slug('Action Figures'),
        ]);

        $boardGamesCategory = Category::create([
            'name' => 'Board Games',
            'code' => Str::slug('Board Games'),
        ]);

        // 3. Create Products
        $gundamProduct = Product::create([
            'name' => 'Gundam RX-78-2 High Grade',
            'code' => 'GRHG-' . rand(1000, 9999),
            'category_id' => $actionFiguresCategory->id,
            'image_path' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?auto=format&fit=crop&q=80&w=300&h=300',
            'stock' => 50,
            'cost' => 150000,
            'price' => 250000,
            'distributor' => 'Multi Toys Indonesia',
        ]);

        $transformersProduct = Product::create([
            'name' => 'Optimus Prime Voyager Class',
            'code' => 'OPVC-' . rand(1000, 9999),
            'category_id' => $actionFiguresCategory->id,
            'image_path' => 'https://images.unsplash.com/photo-1531571432651-025efe33025d?auto=format&fit=crop&q=80&w=300&h=300',
            'stock' => 15,
            'cost' => 280000,
            'price' => 450000,
            'distributor' => 'Kidz Station',
        ]);

        $monopolyProduct = Product::create([
            'name' => 'Monopoly Classic',
            'code' => 'MC-' . rand(1000, 9999),
            'category_id' => $boardGamesCategory->id,
            'image_path' => 'https://images.unsplash.com/photo-1632501641765-e568d28b0015?auto=format&fit=crop&q=80&w=300&h=300',
            'stock' => 100,
            'cost' => 125000,
            'price' => 299000,
            'distributor' => 'Toys City',
        ]);

        $catanProduct = Product::create([
            'name' => 'Catan Board Game',
            'code' => 'CBG-' . rand(1000, 9999),
            'category_id' => $boardGamesCategory->id,
            'image_path' => 'https://images.unsplash.com/photo-1606167668584-78701c57f13d?auto=format&fit=crop&q=80&w=300&h=300',
            'stock' => 30,
            'cost' => 300000,
            'price' => 490000,
            'distributor' => 'Indo Board Game',
        ]);
        // 4. Generate 1,000 Bulk Dummy Products via Faker
        $this->command->info('Generating 1,000 dummy products...');
        
        $faker = \Faker\Factory::create();
        $products = [];
        $categories = [$actionFiguresCategory->id, $boardGamesCategory->id];

        for ($i = 0; $i < 1000; $i++) {
            $cost = $faker->numberBetween(10, 500) * 1000;
            $products[] = [
                'name' => ucwords($faker->words(rand(2, 4), true)),
                'code' => strtoupper($faker->lexify('???')) . '-' . $faker->unique()->numerify('####'),
                'category_id' => $categories[array_rand($categories)],
                'image_path' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?auto=format&fit=crop&q=80&w=300&h=300', // Default shared image
                'stock' => $faker->numberBetween(0, 999),
                'cost' => $cost,
                'price' => $cost + ($faker->numberBetween(5, 50) * 5000),
                'distributor' => $faker->company(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Chunk inserts for extreme performance
        foreach (array_chunk($products, 250) as $chunk) {
            Product::insert($chunk);
        }
        
        $this->command->info('1,000 dummy products inserted successfully!');
    }
}
