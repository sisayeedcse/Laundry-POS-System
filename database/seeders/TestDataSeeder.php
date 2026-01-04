<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test customer if doesn't exist
        $customer = Customer::firstOrCreate(
            ['phone' => '+971501234567'],
            [
                'name' => 'Ahmed Mohammed',
                'address' => 'Sheikh Zayed Road, Dubai, UAE',
            ]
        );

        // Get some services
        $shirt = Service::where('name', 'Shirt')->first();
        $pant = Service::where('name', 'Pant')->first();

        if ($shirt && $pant) {
            // Create a test order
            $order = Order::create([
                'customer_id' => $customer->id,
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => 11.00, // 3.00 + 3.00 + 5.00 (2 shirts wash&iron + 1 pant wash&iron + 5 discount)
                'discount' => 0,
                'tax' => 0,
                'advance_payment' => 0,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => 'cash',
                'delivery_date' => now()->addDays(2),
                'notes' => 'Test order for verification',
            ]);

            // Create order items
            OrderItem::create([
                'order_id' => $order->id,
                'service_id' => $shirt->id,
                'quantity' => 2,
                'service_type' => 'wash_iron',
                'unit_price' => $shirt->price_wash_iron,
                'subtotal' => $shirt->price_wash_iron * 2,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'service_id' => $pant->id,
                'quantity' => 1,
                'service_type' => 'iron_only',
                'unit_price' => $pant->price_iron_only,
                'subtotal' => $pant->price_iron_only,
            ]);

            $customer->incrementOrders();

            $this->command->info('✓ Test customer created: ' . $customer->name);
            $this->command->info('✓ Test order created: ' . $order->order_number);
            $this->command->info('✓ Order items: 2 Shirts (Wash & Iron) + 1 Pant (Iron Only)');
            $this->command->info('✓ Total: AED ' . number_format($order->total_amount, 2));
        } else {
            $this->command->error('Services not found! Please run ActualServicePricesSeeder first.');
        }
    }
}
