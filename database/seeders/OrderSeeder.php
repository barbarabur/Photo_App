<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Photo;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Obtener usuarios y fotos existentes
        $photos = Photo::all();
        $clients = User::role('client')->get();


        //status de los pedidos
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];

        //crear 20 pedidos
        for ($i = 0; $i<20; $i++) {
            $client = $clients->random();

            $order = Order::create([
                'total_price' => 0,
                'status' =>$statuses [array_rand($statuses)],
                'user_id' => $client->id,
            ]);
       // Seleccionar entre 1 y 3 fotos aleatorias
       $selectedPhotos = $photos->random(rand(1, min(3, $photos->count())));

       if ($selectedPhotos->isNotEmpty()) {
            $order->photos()->attach($photos->pluck('id'));
        }
        //calcular y actualizar el precio del pedido
        $totalPrice = $photos->sum('price');
        $order->update(['total_price' =>$totalPrice]);
        }
        $this->command->info('Se crearon 10 pedidos para clientes exitosamente.');

    }
}
