<?php

namespace Database\Seeders;

use App\Models\Preorder;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class PreorderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $products = Product::all();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('Users or Products not found. Run UserSeeder and ProductSeeder first.');
            return;
        }

        // Create 10 sample preorders
        for ($i = 0; $i < 10; $i++) {
            Preorder::create([
                'user_id' => $customers->random()->id,
                'product_id' => $products->random()->id,
                'qty' => rand(1, 10),
                'expected_ship_date' => now()->addDays(rand(7, 60)),
                'status' => ['open', 'confirmed', 'shipped'][rand(0, 2)],
                'created_at' => now()->subDays(rand(0, 30)),
            ]);
        }

        $this->command->info('Preorder seeder completed with 10 sample preorders.');
    }
}
