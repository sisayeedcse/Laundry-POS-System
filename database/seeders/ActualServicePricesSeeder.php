<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ActualServicePricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Based on actual UAE/Qatar laundry price list
     */
    public function run(): void
    {
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing services
        Service::truncate();
        
        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $services = [
            // === CLOTHING ===
            [
                'name' => 'Shirt',
                'category' => 'Clothing',
                'price_wash_iron' => 3.00,
                'price_iron_only' => 2.00,
                'description' => 'Regular shirt washing and ironing',
                'is_active' => true,
            ],
            [
                'name' => 'T-Shirt',
                'category' => 'Clothing',
                'price_wash_iron' => 3.00,
                'price_iron_only' => null,
                'description' => 'T-Shirt wash and iron service',
                'is_active' => true,
            ],
            [
                'name' => 'Pant',
                'category' => 'Clothing',
                'price_wash_iron' => 3.00,
                'price_iron_only' => 2.00,
                'description' => 'Trouser/Pant cleaning and pressing',
                'is_active' => true,
            ],
            [
                'name' => 'Baniyan',
                'category' => 'Clothing',
                'price_wash_iron' => 1.00,
                'price_iron_only' => null,
                'description' => 'Undershirt washing service',
                'is_active' => true,
            ],
            [
                'name' => 'Track Suit',
                'category' => 'Clothing',
                'price_wash_iron' => 3.00,
                'price_iron_only' => null,
                'description' => 'Track suit washing service',
                'is_active' => true,
            ],
            [
                'name' => 'Sweater',
                'category' => 'Clothing',
                'price_wash_iron' => 5.00,
                'price_iron_only' => null,
                'description' => 'Sweater cleaning service',
                'is_active' => true,
            ],
            [
                'name' => 'Lungi',
                'category' => 'Clothing',
                'price_wash_iron' => 3.00,
                'price_iron_only' => null,
                'description' => 'Lungi washing service',
                'is_active' => true,
            ],
            [
                'name' => 'Overall',
                'category' => 'Clothing',
                'price_wash_iron' => 6.00,
                'price_iron_only' => null,
                'description' => 'Overall/Coverall cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Waistcoat',
                'category' => 'Clothing',
                'price_wash_iron' => 6.00,
                'price_iron_only' => null,
                'description' => 'Waistcoat cleaning service',
                'is_active' => true,
            ],

            // === TRADITIONAL WEAR ===
            [
                'name' => 'Thobe',
                'category' => 'Traditional Wear',
                'price_wash_iron' => 5.00,
                'price_iron_only' => 3.00,
                'description' => 'Traditional thobe cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Salwar Kameez',
                'category' => 'Traditional Wear',
                'price_wash_iron' => 6.00,
                'price_iron_only' => 4.00,
                'description' => 'Traditional salwar kameez cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Ladies Salwar Kameez',
                'category' => 'Traditional Wear',
                'price_wash_iron' => 6.00,
                'price_iron_only' => 6.00,
                'description' => 'Ladies salwar kameez cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Abaya',
                'category' => 'Traditional Wear',
                'price_wash_iron' => 8.00,
                'price_iron_only' => 4.00,
                'description' => 'Traditional abaya cleaning and pressing',
                'is_active' => true,
            ],
            [
                'name' => 'Tharka',
                'category' => 'Traditional Wear',
                'price_wash_iron' => 3.00,
                'price_iron_only' => 2.00,
                'description' => 'Tharka cleaning service',
                'is_active' => true,
            ],
            [
                'name' => 'Ghutra',
                'category' => 'Traditional Wear',
                'price_wash_iron' => 3.00,
                'price_iron_only' => 2.00,
                'description' => 'Ghutra cleaning service',
                'is_active' => true,
            ],

            // === FORMAL WEAR ===
            [
                'name' => 'Coat + Pant',
                'category' => 'Formal Wear',
                'price_wash_iron' => 20.00,
                'price_iron_only' => 12.00,
                'description' => 'Full suit dry cleaning service',
                'is_active' => true,
            ],
            [
                'name' => 'Coat Only',
                'category' => 'Formal Wear',
                'price_wash_iron' => 16.00,
                'price_iron_only' => null,
                'description' => 'Coat only dry cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Long Coat',
                'category' => 'Formal Wear',
                'price_wash_iron' => 20.00,
                'price_iron_only' => null,
                'description' => 'Long coat dry cleaning',
                'is_active' => true,
            ],

            // === OUTERWEAR ===
            [
                'name' => 'Jacket (Standard)',
                'category' => 'Outerwear',
                'price_wash_iron' => 10.00,
                'price_iron_only' => 6.00,
                'description' => 'Standard jacket cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Jacket (Heavy)',
                'size_variant' => 'heavy',
                'category' => 'Outerwear',
                'price_wash_iron' => 12.00,
                'price_iron_only' => 6.00,
                'description' => 'Heavy jacket cleaning',
                'is_active' => true,
            ],

            // === UNIFORM ===
            [
                'name' => 'Military Suit',
                'category' => 'Uniform',
                'price_wash_iron' => 16.00,
                'price_iron_only' => 6.00,
                'description' => 'Military uniform cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Apron',
                'category' => 'Uniform',
                'price_wash_iron' => 5.00,
                'price_iron_only' => null,
                'description' => 'Apron cleaning service',
                'is_active' => true,
            ],

            // === LADIES WEAR ===
            [
                'name' => 'Ladies Frock',
                'category' => 'Ladies Wear',
                'price_wash_iron' => 12.00,
                'price_iron_only' => null,
                'description' => 'Ladies frock cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Ladies Dress (Standard)',
                'category' => 'Ladies Wear',
                'price_wash_iron' => 15.00,
                'price_iron_only' => null,
                'description' => 'Standard ladies dress',
                'is_active' => true,
            ],
            [
                'name' => 'Ladies Dress (Medium)',
                'size_variant' => 'medium',
                'category' => 'Ladies Wear',
                'price_wash_iron' => 20.00,
                'price_iron_only' => null,
                'description' => 'Medium ladies dress',
                'is_active' => true,
            ],
            [
                'name' => 'Ladies Dress (Heavy)',
                'size_variant' => 'heavy',
                'category' => 'Ladies Wear',
                'price_wash_iron' => 25.00,
                'price_iron_only' => null,
                'description' => 'Heavy/Designer ladies dress',
                'is_active' => true,
            ],

            // === ACCESSORIES ===
            [
                'name' => 'Shawl (Standard)',
                'category' => 'Accessories',
                'price_wash_iron' => 5.00,
                'price_iron_only' => null,
                'description' => 'Standard shawl cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Shawl (Heavy)',
                'size_variant' => 'heavy',
                'category' => 'Accessories',
                'price_wash_iron' => 7.00,
                'price_iron_only' => null,
                'description' => 'Heavy shawl cleaning',
                'is_active' => true,
            ],

            // === BEDDING ===
            [
                'name' => 'Blanket (Small)',
                'size_variant' => 'small',
                'category' => 'Bedding',
                'price_wash_iron' => 15.00,
                'price_iron_only' => null,
                'description' => 'Small blanket cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Blanket (Medium)',
                'size_variant' => 'medium',
                'category' => 'Bedding',
                'price_wash_iron' => 25.00,
                'price_iron_only' => null,
                'description' => 'Medium blanket cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Blanket (Big)',
                'size_variant' => 'big',
                'category' => 'Bedding',
                'price_wash_iron' => 30.00,
                'price_iron_only' => null,
                'description' => 'Large blanket cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Bedsheet (Standard)',
                'category' => 'Bedding',
                'price_wash_iron' => 5.00,
                'price_iron_only' => null,
                'description' => 'Standard bedsheet cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Bedsheet (Large)',
                'size_variant' => 'large',
                'category' => 'Bedding',
                'price_wash_iron' => 6.00,
                'price_iron_only' => null,
                'description' => 'Large bedsheet cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Pillow Cover',
                'category' => 'Bedding',
                'price_wash_iron' => 1.00,
                'price_iron_only' => null,
                'description' => 'Pillow cover cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Towel (Small)',
                'size_variant' => 'small',
                'category' => 'Bedding',
                'price_wash_iron' => 4.00,
                'price_iron_only' => null,
                'description' => 'Small towel cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Towel (Big)',
                'size_variant' => 'big',
                'category' => 'Bedding',
                'price_wash_iron' => 5.00,
                'price_iron_only' => null,
                'description' => 'Large towel cleaning',
                'is_active' => true,
            ],

            // === HOME TEXTILES ===
            [
                'name' => 'Curtain (Small)',
                'size_variant' => 'small',
                'category' => 'Home Textiles',
                'price_wash_iron' => 20.00,
                'price_iron_only' => null,
                'description' => 'Small curtain cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Curtain (Medium)',
                'size_variant' => 'medium',
                'category' => 'Home Textiles',
                'price_wash_iron' => 25.00,
                'price_iron_only' => null,
                'description' => 'Medium curtain cleaning',
                'is_active' => true,
            ],
            [
                'name' => 'Curtain (Big)',
                'size_variant' => 'big',
                'category' => 'Home Textiles',
                'price_wash_iron' => 30.00,
                'price_iron_only' => null,
                'description' => 'Large curtain cleaning',
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}

