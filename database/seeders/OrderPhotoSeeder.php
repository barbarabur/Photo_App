<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Photo;
use Illuminate\Support\Facades\DB;


class OrderPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los pedidos y fotos existentes
        $orders = Order::all();
        $photos = Photo::all();    
    // Asociar fotos a pedidos
    foreach ($orders as $order) {
        // Seleccionar entre 1 y 5 fotos aleatorias
        $randomPhotos = $photos->random(rand(1, min(5, $photos->count())));

        // Asociar las fotos al pedido
        foreach ($randomPhotos as $photo) {
            $order->photos()->attach($photo->id, [
                // Puedes añadir campos adicionales del pivote aquí si los tienes
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Actualizar el precio total del pedido (suma de precios de las fotos)
        $totalPrice = $order->photos->sum('price');
        $order->update(['total_price' => $totalPrice]);
    }

    }
}
