<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin POS',
            'email' => 'admin@local.test',
            'password' => bcrypt('Password123!'),
        ]);

        $storeA = Store::create([
            'name' => 'Victory Toys Central',
            'code' => 'VTC-' . rand(1000, 9999),
            'store_category' => 'Store A',
            'address' => 'Jl. Merdeka No. 10, Jakarta',
            'is_active' => true,
        ]);

        $storeB = Store::create([
            'name' => 'Victory Toys Premium',
            'code' => 'VTP-' . rand(1000, 9999),
            'store_category' => 'Store B',
            'address' => 'Jl. Sudirman No. 88, Bandung',
            'is_active' => true,
        ]);

        $storeC = Store::create([
            'name' => 'Victory Toys Warehouse',
            'code' => 'VTW-' . rand(1000, 9999),
            'store_category' => 'Store C',
            'address' => 'Jl. Industri Raya No. 21, Surabaya',
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Gundam RX-78-2 High Grade',
            'code' => 'GRHG-' . rand(1000, 9999),
            'store_id' => $storeA->id,
            'stock' => 50,
            'cost' => 150000,
            'price' => 250000,
            'distributor' => 'Multi Toys Indonesia',
        ]);

        Product::create([
            'name' => 'Optimus Prime Voyager Class',
            'code' => 'OPVC-' . rand(1000, 9999),
            'store_id' => $storeA->id,
            'stock' => 15,
            'cost' => 280000,
            'price' => 450000,
            'distributor' => 'Kidz Station',
        ]);

        Product::create([
            'name' => 'Monopoly Classic',
            'code' => 'MC-' . rand(1000, 9999),
            'store_id' => $storeB->id,
            'stock' => 100,
            'cost' => 125000,
            'price' => 299000,
            'distributor' => 'Toys City',
        ]);

        Product::create([
            'name' => 'Catan Board Game',
            'code' => 'CBG-' . rand(1000, 9999),
            'store_id' => $storeC->id,
            'stock' => 30,
            'cost' => 300000,
            'price' => 490000,
            'distributor' => 'Indo Board Game',
        ]);

        $this->command->info('Generating 1,000 dummy products...');

        $faker = \Faker\Factory::create();
        $products = [];
        $stores = [$storeA->id, $storeB->id, $storeC->id];

        for ($i = 0; $i < 1000; $i++) {
            $cost = $faker->numberBetween(10, 500) * 1000;
            $products[] = [
                'name' => ucwords($faker->words(rand(2, 4), true)),
                'code' => strtoupper($faker->lexify('???')) . '-' . $faker->unique()->numerify('####'),
                'store_id' => $stores[array_rand($stores)],
                'stock' => $faker->numberBetween(0, 999),
                'cost' => $cost,
                'price' => $cost + ($faker->numberBetween(5, 50) * 5000),
                'distributor' => $faker->company(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach (array_chunk($products, 250) as $chunk) {
            Product::insert($chunk);
        }

        $this->command->info('1,000 dummy products inserted successfully!');
    }
}
