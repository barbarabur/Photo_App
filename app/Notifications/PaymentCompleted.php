<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentCompleted extends Notification
{
    use Queueable;
    protected $order;

   
    public function __construct()
    {
        $this->order = $order;
    }
//indica que se enviará poe email
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Pago completado')
        ->greeting('¡Hola ' . $notifiable->name . '!')
        ->line('Tu pago para la orden #' . $this->order->id . ' ha sido completado correctamente.')
        ->action('Ver Orden', url('/orders/' . $this->order->id))
        ->line('Gracias por usar nuestro servicio.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
