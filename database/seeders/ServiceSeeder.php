<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Shirt',
                'category' => 'Clothing',
                'price_wash_iron' => 10.00,
                'price_iron_only' => 5.00,
                'description' => 'Regular shirt washing and ironing service',
                'is_active' => true,
            ],
            [
                'name' => 'Pant',
                'category' => 'Clothing',
                'price_wash_iron' => 12.00,
                'price_iron_only' => 6.00,
                'description' => 'Trouser/Pant cleaning and pressing',
                'is_active' => true,
            ],
            [
                'name' => 'Selwar-Kamij',
                'category' => 'Traditional Wear',
                'price_wash_iron' => 20.00,
                'price_iron_only' => 10.00,
                'description' => 'Traditional dress cleaning service',
                'is_active' => true,
            ],
            [
                'name' => 'Banian (Undershirt)',
                'category' => 'Clothing',
                'price_wash_iron' => 5.00,
                'price_iron_only' => 3.00,
                'description' => 'Undershirt washing service',
                'is_active' => true,
            ],
            [
                'name' => 'Blanket',
                'category' => 'Bedding',
                'price_wash_iron' => 50.00,
                'price_iron_only' => null,
                'description' => 'Heavy blanket dry cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Thobe (White)',
                'category' => 'Traditional Wear',
                'price_wash_iron' => 25.00,
                'price_iron_only' => 12.00,
                'description' => 'Traditional white thobe cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Thobe (Colored)',
                'category' => 'Traditional Wear',
                'price_wash_iron' => 30.00,
                'price_iron_only' => 15.00,
                'description' => 'Colored thobe specialized cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Abaya',
                'category' => 'Traditional Wear',
                'price_wash_iron' => 30.00,
                'price_iron_only' => 15.00,
                'description' => 'Traditional abaya cleaning and pressing',
                'is_active' => true,
            ],
            [
                'name' => 'Court/Suit',
                'category' => 'Formal Wear',
                'price_wash_iron' => 40.00,
                'price_iron_only' => 20.00,
                'description' => 'Full suit dry cleaning service',
                'is_active' => true,
            ],
            [
                'name' => 'Security Shirt',
                'category' => 'Uniform',
                'price_wash_iron' => 15.00,
                'price_iron_only' => 7.00,
                'description' => 'Security uniform shirt service',
                'is_active' => true,
            ],
            [
                'name' => 'Jacket',
                'category' => 'Outerwear',
                'price_wash_iron' => 35.00,
                'price_iron_only' => 18.00,
                'description' => 'Jacket dry cleaning and care',
                'is_active' => true,
            ],
            [
                'name' => 'Others',
                'category' => 'Miscellaneous',
                'price_wash_iron' => 10.00,
                'price_iron_only' => 5.00,
                'description' => 'Other laundry items',
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
