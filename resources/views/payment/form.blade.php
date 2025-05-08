@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pago por Orden #{{ $order->id }}</h2>
    <p>Total: <strong>{{ $order->total_price }}€</strong></p>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('payments.process', $orderId) }}" method="POST" id="payment-form">
        @csrf
        <div class="form-group">
            <label for="card-element">Tarjeta de crédito</label>
            <div id="card-element"></div>
            <div id="card-errors" role="alert"></div>
        </div>
        <button class="btn btn-primary mt-3">Pagar</button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
const stripe = Stripe("{{ config('services.stripe.key') }}");

const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const {token, error} = await stripe.createToken(card);

        if (error) {
            document.getElementById('card-errors').textContent = error.message;
        } else {
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            form.submit();
        }
    });
</script>
@endsection
