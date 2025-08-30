<?php

namespace Database\Seeders;

use App\Models\Merch;
use Illuminate\Database\Seeder;

class MerchSeeder extends Seeder
{
    public function run(): void
    {
        $merchandise = [
            [
                'name' => 'Official T-Shirts',
                'description' => 'High-quality cotton t-shirts with the UOM logo and engineering-themed designs.',
                'category' => 'tshirts',
                'price' => 1500.00,
                'image_url' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'is_available' => true,
                'stock_quantity' => 50,
            ],
            [
                'name' => 'EFSU Baseball Caps',
                'description' => 'Stylish baseball caps with embroidered EFSU logo. Perfect for sunny days on campus.',
                'category' => 'caps',
                'price' => 800.00,
                'image_url' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'is_available' => true,
                'stock_quantity' => 30,
            ],
            [
                'name' => 'Engineering Wrist Bands',
                'description' => 'Durable silicone wrist bands with motivational engineering quotes and EFSU branding.',
                'category' => 'wristbands',
                'price' => 250.00,
                'image_url' => 'https://images.unsplash.com/photo-1611652022419-a9419f74343d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'is_available' => true,
                'stock_quantity' => 100,
            ],
            [
                'name' => 'EFSU Logo Stickers',
                'description' => 'Waterproof vinyl stickers featuring the EFSU logo. Great for laptops and water bottles.',
                'category' => 'stickers',
                'price' => 100.00,
                'image_url' => 'https://images.unsplash.com/photo-1581833971358-2c8b550f87b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'is_available' => true,
                'stock_quantity' => 200,
            ],
            [
                'name' => 'Engineering Hoodie',
                'description' => 'Comfortable fleece hoodie with EFSU and University of Moratuwa branding.',
                'category' => 'tshirts',
                'price' => 3500.00,
                'image_url' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'is_available' => true,
                'stock_quantity' => 25,
            ],
            [
                'name' => 'Limited Edition Cap',
                'description' => 'Special edition cap commemorating the 50th anniversary of the Engineering Faculty.',
                'category' => 'caps',
                'price' => 1200.00,
                'image_url' => 'https://images.unsplash.com/photo-1575428652377-a2d80e2277fc?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                'is_available' => false,
                'stock_quantity' => 0,
            ],
        ];

        foreach ($merchandise as $item) {
            Merch::create($item);
        }

        $this->command->info('Merchandise seeded successfully!');
    }
}
