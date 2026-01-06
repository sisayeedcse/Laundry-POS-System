<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class LaundryServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only add services if none exist
        if (Service::count() > 0) {
            $this->command->warn('Services already exist. Skipping seed.');
            return;
        }

        $services = [
            // Standard items
            ['name' => 'Shirt', 'category' => 'Clothing', 'price_wash_iron' => 3.00, 'price_iron_only' => 2.00],
            ['name' => 'T-Shirt', 'category' => 'Clothing', 'price_wash_iron' => 3.00, 'price_iron_only' => null],
            ['name' => 'Pant', 'category' => 'Clothing', 'price_wash_iron' => 3.00, 'price_iron_only' => 2.00],
            ['name' => 'Thobe', 'category' => 'Traditional', 'price_wash_iron' => 5.00, 'price_iron_only' => 3.00],
            ['name' => 'Coat + Pant', 'category' => 'Formal', 'price_wash_iron' => 20.00, 'price_iron_only' => 12.00],
            ['name' => 'Coat Only', 'category' => 'Formal', 'price_wash_iron' => 16.00, 'price_iron_only' => null],
            ['name' => 'Shawl Standard', 'category' => 'Accessories', 'price_wash_iron' => 5.00, 'price_iron_only' => null],
            ['name' => 'Shawl Large', 'category' => 'Accessories', 'price_wash_iron' => 7.00, 'price_iron_only' => null],
            ['name' => 'Apron', 'category' => 'Accessories', 'price_wash_iron' => 5.00, 'price_iron_only' => null],
            ['name' => 'Jacket Standard', 'category' => 'Outerwear', 'price_wash_iron' => 10.00, 'price_iron_only' => 6.00],
            ['name' => 'Jacket Large', 'category' => 'Outerwear', 'price_wash_iron' => 12.00, 'price_iron_only' => 6.00],
            ['name' => 'Sweater', 'category' => 'Clothing', 'price_wash_iron' => 5.00, 'price_iron_only' => null],
            ['name' => 'Track Suit', 'category' => 'Sportswear', 'price_wash_iron' => 3.00, 'price_iron_only' => null],
            ['name' => 'Baniyan', 'category' => 'Innerwear', 'price_wash_iron' => 1.00, 'price_iron_only' => null],
            ['name' => 'Towel Big', 'category' => 'Home', 'price_wash_iron' => 4.00, 'price_iron_only' => null],
            ['name' => 'Towel Small', 'category' => 'Home', 'price_wash_iron' => 5.00, 'price_iron_only' => null],
            
            ['name' => 'Long Coat', 'category' => 'Outerwear', 'price_wash_iron' => 20.00, 'price_iron_only' => null],
            ['name' => 'Overall', 'category' => 'Workwear', 'price_wash_iron' => 6.00, 'price_iron_only' => null],
            ['name' => 'Waistcoat', 'category' => 'Formal', 'price_wash_iron' => 6.00, 'price_iron_only' => null],
            ['name' => 'Salwar Kameez', 'category' => 'Traditional', 'price_wash_iron' => 6.00, 'price_iron_only' => 4.00],
            ['name' => 'Lungi', 'category' => 'Traditional', 'price_wash_iron' => 3.00, 'price_iron_only' => null],
            ['name' => 'Pillow Cover', 'category' => 'Home', 'price_wash_iron' => 1.00, 'price_iron_only' => null],
            ['name' => 'Abaya', 'category' => 'Traditional', 'price_wash_iron' => 8.00, 'price_iron_only' => 4.00],
            ['name' => 'Tharka', 'category' => 'Traditional', 'price_wash_iron' => 3.00, 'price_iron_only' => 2.00],
            ['name' => 'Ladies Frock', 'category' => 'Ladies', 'price_wash_iron' => 12.00, 'price_iron_only' => null],
            ['name' => 'Curtain Big', 'category' => 'Home', 'price_wash_iron' => 20.00, 'price_iron_only' => null],
            ['name' => 'Curtain Medium', 'category' => 'Home', 'price_wash_iron' => 25.00, 'price_iron_only' => null],
            ['name' => 'Curtain Small', 'category' => 'Home', 'price_wash_iron' => 30.00, 'price_iron_only' => null],
            ['name' => 'Ghutra', 'category' => 'Traditional', 'price_wash_iron' => 3.00, 'price_iron_only' => 2.00],
            ['name' => 'Blanket Big', 'category' => 'Home', 'price_wash_iron' => 15.00, 'price_iron_only' => null],
            ['name' => 'Blanket Medium', 'category' => 'Home', 'price_wash_iron' => 25.00, 'price_iron_only' => null],
            ['name' => 'Blanket Small', 'category' => 'Home', 'price_wash_iron' => 30.00, 'price_iron_only' => null],
            ['name' => 'Bedsheet Standard', 'category' => 'Home', 'price_wash_iron' => 5.00, 'price_iron_only' => null],
            ['name' => 'Bedsheet Large', 'category' => 'Home', 'price_wash_iron' => 6.00, 'price_iron_only' => null],
            ['name' => 'Military Suit', 'category' => 'Uniform', 'price_wash_iron' => 16.00, 'price_iron_only' => 6.00],
            ['name' => 'Ladies Dress Small', 'category' => 'Ladies', 'price_wash_iron' => 15.00, 'price_iron_only' => null],
            ['name' => 'Ladies Dress Medium', 'category' => 'Ladies', 'price_wash_iron' => 20.00, 'price_iron_only' => null],
            ['name' => 'Ladies Dress Large', 'category' => 'Ladies', 'price_wash_iron' => 25.00, 'price_iron_only' => null],
            
            ['name' => 'Ladies Salwar Kameez', 'category' => 'Ladies', 'price_wash_iron' => 0.00, 'price_iron_only' => 6.00],
        ];

        foreach ($services as $service) {
            Service::create([
                'name' => $service['name'],
                'size_variant' => $service['size_variant'] ?? null,
                'category' => $service['category'],
                'price_wash_iron' => $service['price_wash_iron'],
                'price_iron_only' => $service['price_iron_only'],
                'is_active' => true,
            ]);
        }
    }
}
