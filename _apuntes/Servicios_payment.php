Creamos el servicio en App/Services PaymentService.php

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
?>

Usamos el servicio en PaymentControler

<?php
use App\Services\PaymentService;

public function processPayment(Request $request, $orderId, PaymentService $paymentService)
{
    $order = Order::findOrFail($orderId);

    // ... lógica de Stripe aquí ...

    try {
        // ... Stripe::setApiKey y Charge::create() ...

        // Usar el service para completar y notificar
        $paymentService->completeOrder($order);

        return redirect()->route('orders.index')->with('success','Pago realizado con éxito');
    } catch (\Exception $e) {
        return back()->with('error', 'Error al procesar el pago');
    }
}


// generamos la notificación app/Notifivcations/PaymetCompleted
php artisan make:notification PaymentCompleted


use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentCompleted extends Notification
{
    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    // Indica que se enviará por email
    public function via($notifiable)
    {
        return ['mail'];
    }

    // Construye el contenido del email
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Pago completado')
                    ->greeting('¡Hola ' . $notifiable->name . '!')
                    ->line('Tu pago para la orden #' . $this->order->id . ' ha sido completado correctamente.')
                    ->action('Ver Orden', url('/orders/' . $this->order->id))
                    ->line('Gracias por usar nuestro servicio.');
    }
}


Configuramos .env y config/mal.php