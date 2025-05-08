<?php
namespace App\Services;

use App\Models\Order;
use App\Notifications\PaymentCompleted;

class PaymentService
{
    public function completeOrder(Order $order)
    {
        // Cambiar estado
        $order->status = 'completed';
        $order->save();

        // Enviar notificación al usuario
        $order->user->notify(new PaymentCompleted($order));
    }
}
