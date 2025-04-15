<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Payment;


class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {//obtener las orders
        $orders = Order::where('status', 'completed')->get();

        if ($orders->isEmpty()) {
            $this->command->error('No hay pedidos disponibles. Ejecuta OrderSeeder primero.');
            return;
        }

        //crear payments
       
        $orders->each(function ($order) {
            $order->payment()->create([
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        });
    }
}
