<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function showPaymentForm($orderId)
    {
        $order = Order::with('photos')->findOrFail($orderId);
        return view('payments.form', compact('order'));
    }

    public function processPayment(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        Stripe::setApiKey(config('services.stripe.secret'));
        $lineItems = [];

        foreach ($order->photos as $photo) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $photo->title,
                    ],
                    'unit_amount' => $photo->price * 100,
                ],
                'quantity' => 1,
            ];
        }
    
        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('orders.photo') . '?success=true',
            'cancel_url' => route('orders.photo') . '?canceled=true',
        ]);
    
        return redirect($session->url);
    }



}