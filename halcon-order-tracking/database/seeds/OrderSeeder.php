<?php

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\StatusHistory;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $salesUser = User::where('email', 'ventas@halcon.com')->first();

        $orders = [
            [
                'invoice_number'   => 'INV-0001',
                'customer_name'    => 'Empresa Alfa S.A.',
                'customer_number'  => 'CLI-001',
                'rfc'              => 'EAL010101AAA',
                'fiscal_address'   => 'Av. Reforma 100, CDMX',
                'fiscal_email'     => 'facturacion@alfa.com',
                'delivery_address' => 'Calle 5 de Mayo 22, CDMX',
                'notes'            => 'Entregar en horario matutino',
                'order_date'       => now()->subDays(10),
                'status'           => Order::STATUS_DELIVERED,
                'deleted'          => 0,
            ],
            [
                'invoice_number'   => 'INV-0002',
                'customer_name'    => 'Distribuidora Beta',
                'customer_number'  => 'CLI-002',
                'rfc'              => 'DBE020202BBB',
                'fiscal_address'   => 'Blvd. Juárez 200, Monterrey',
                'fiscal_email'     => 'cuentas@beta.com',
                'delivery_address' => 'Calle Hidalgo 45, Monterrey',
                'notes'            => null,
                'order_date'       => now()->subDays(5),
                'status'           => Order::STATUS_IN_ROUTE,
                'deleted'          => 0,
            ],
            [
                'invoice_number'   => 'INV-0003',
                'customer_name'    => 'Comercial Gamma',
                'customer_number'  => 'CLI-003',
                'rfc'              => 'CGA030303CCC',
                'fiscal_address'   => 'Av. Insurgentes 300, Guadalajara',
                'fiscal_email'     => 'pagos@gamma.com',
                'delivery_address' => 'Calzada Independencia 80, Guadalajara',
                'notes'            => 'Llamar antes de entregar',
                'order_date'       => now()->subDays(3),
                'status'           => Order::STATUS_IN_PROCESS,
                'deleted'          => 0,
            ],
            [
                'invoice_number'   => 'INV-0004',
                'customer_name'    => 'Grupo Delta',
                'customer_number'  => 'CLI-004',
                'rfc'              => 'GDE040404DDD',
                'fiscal_address'   => 'Calle Morelos 400, Puebla',
                'fiscal_email'     => 'admin@delta.com',
                'delivery_address' => 'Av. Juárez 10, Puebla',
                'notes'            => null,
                'order_date'       => now()->subDay(),
                'status'           => Order::STATUS_ORDERED,
                'deleted'          => 0,
            ],
        ];

        foreach ($orders as $orderData) {
            $orderData['created_by'] = $salesUser->id;
            $order = Order::create($orderData);
            StatusHistory::log($order->id, null, $order->status, $salesUser->id);
        }
    }
}
