<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $products = Product::all();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('Users or Products not found. Run UserSeeder and ProductSeeder first.');
            return;
        }

        $statuses = ['pending', 'paid', 'processing', 'shipped', 'completed', 'cancelled'];

        // Create 15 sample orders
        for ($i = 0; $i < 15; $i++) {
            $customer = $customers->random();
            $status = $statuses[array_rand($statuses)];
            $itemCount = rand(1, 5);
            $totalAmount = 0;

            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => $customer->id,
                'status' => $status,
                'payment_method' => ['credit_card', 'paypal', 'bank_transfer'][rand(0, 2)],
                'payment_reference' => 'TXN-' . strtoupper(uniqid()),
                'shipping_address' => json_encode([
                    'street' => '123 Main St',
                    'city' => 'New York',
                    'state' => 'NY',
                    'zip' => '10001',
                    'country' => 'USA',
                ]),
                'billing_address' => json_encode([
                    'street' => '123 Main St',
                    'city' => 'New York',
                    'state' => 'NY',
                    'zip' => '10001',
                    'country' => 'USA',
                ]),
                'shipping_cost' => 0,
                'total_amount' => 0, // Will be updated after items
                'created_at' => now()->subDays(rand(0, 60)),
                'updated_at' => now()->subDays(rand(0, 60)),
            ]);

            // Add order items
            for ($j = 0; $j < $itemCount; $j++) {
                $product = $products->random();
                $qty = rand(1, 5);
                $price = $product->price;
                $subtotal = $price * $qty;
                $totalAmount += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'price_snapshot' => $price,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                ]);
            }

            // Update order total
            $order->update(['total_amount' => $totalAmount]);
        }

        $this->command->info('Order seeder completed with 15 sample orders.');
    }
}
