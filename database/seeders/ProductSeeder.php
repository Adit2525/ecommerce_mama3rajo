<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Use existing images
        $images = [
            'images/pashmina.png',
            'images/square.png',
            'images/hero.png'
        ];

        $products = [
            [
                'sku' => 'FASH-001',
                'name' => 'Premium Chiffon Hijab - Dusty Pink',
                'slug' => Str::slug('Premium Chiffon Hijab Dusty Pink'),
                'description' => 'Elegant and lightweight chiffon hijab, perfect for daily wear or special occasions. Breathable fabric with a subtle texture.',
                'price' => 125000.00,
                'cost_price' => 50000.00,
                'stock' => 50,
                'weight' => 0.15,
                'status' => 'active',
                'images' => ['images/pashmina.png'],
                'category_id' => 1,
            ],
            [
                'sku' => 'FASH-002',
                'name' => 'Emerald Satin Silk Hijab',
                'slug' => Str::slug('Emerald Satin Silk Hijab'),
                'description' => 'Luxurious emerald green satin hijab. Modest cut with a flowing silhouette, perfect for evening events.',
                'price' => 145000.00,
                'cost_price' => 60000.00,
                'stock' => 20,
                'weight' => 0.60,
                'status' => 'active',
                'images' => ['images/square.png'],
                'category_id' => 2,
            ],
            [
                'sku' => 'FASH-003',
                'name' => 'Oversized Cotton Scarf',
                'slug' => Str::slug('Oversized Cotton Scarf'),
                'description' => 'Crisp white cotton scarf with an oversized fit. minimalist design, comfortable and chic for any season.',
                'price' => 89000.00,
                'cost_price' => 35000.00,
                'stock' => 35,
                'weight' => 0.30,
                'status' => 'active',
                'images' => ['images/hero.png', 'images/pashmina.png'],
                'category_id' => 2,
            ],
            [
                'sku' => 'FASH-004',
                'name' => 'Pleated Pashmina - Beige',
                'slug' => Str::slug('Pleated Pashmina Beige'),
                'description' => 'Textured pleated pashmina in a soft beige tone. Versatile and elegant.',
                'price' => 99000.00,
                'cost_price' => 40000.00,
                'stock' => 25,
                'weight' => 0.40,
                'status' => 'active',
                'images' => ['images/pashmina.png'],
                'category_id' => 2,
            ],
            [
                'sku' => 'FASH-005',
                'name' => 'Jersey Hijab - Taupe',
                'slug' => Str::slug('Jersey Hijab Taupe'),
                'description' => 'Soft stretch jersey hijab. No pins needed, stays in place all day.',
                'price' => 75000.00,
                'cost_price' => 25000.00,
                'stock' => 60,
                'weight' => 0.20,
                'status' => 'active',
                'images' => ['images/square.png'],
                'category_id' => 1,
            ],
            [
                'sku' => 'FASH-006',
                'name' => 'Voal Square - Olive',
                'slug' => Str::slug('Voal Square Olive'),
                'description' => 'Classic voal square hijab in natural color. Breathable and stylish.',
                'price' => 55000.00,
                'cost_price' => 20000.00,
                'stock' => 30,
                'weight' => 0.45,
                'status' => 'active',
                'images' => ['images/square.png'],
                'category_id' => 2,
            ],
            [
                'sku' => 'FASH-007',
                'name' => 'Silk Scarf Print Series',
                'slug' => Str::slug('Silk Scarf Print Series'),
                'description' => 'Printed silk scarf with geometric patterns. Adds a pop of color to any outfit.',
                'price' => 185000.00,
                'cost_price' => 80000.00,
                'stock' => 40,
                'weight' => 0.10,
                'status' => 'active',
                'images' => ['images/pashmina.png', 'images/square.png'],
                'category_id' => 1,
            ],
             [
                'sku' => 'FASH-008',
                'name' => 'Instant Hijab - Grey',
                'slug' => Str::slug('Instant Hijab Grey'),
                'description' => 'Practical instant hijab. Cozy layer for cooler days.',
                'price' => 65000.00,
                'cost_price' => 25000.00,
                'stock' => 15,
                'weight' => 0.70,
                'status' => 'active',
                'images' => ['images/hero.png'],
                'category_id' => 2,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
