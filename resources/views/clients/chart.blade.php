@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Your purchases list: </h2>

    @if ($photos ->isEmpty())
        <div class = "alert alert-info">
        Your Pourchases list is empty. Find a photo and add to it!
        </div>
    @else
        <div class ="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($photos as $photo)
                <div class = "col">
                    <div class = "card h-100 shadow-sm">
                        <a href="{{ route('photos.show', $photo->id) }}">
                            <img src="{{ asset($photo->url) }}" alt="{{ $photo->title }}" class="card-img-top">

                        </a>
                    <div class="card-body">
                            <h5 class="card-title">{{ $photo->title }}</h5>
                            <p class="card-text text-muted">{{ $photo->price }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="card-body">
            <h5 class="card-title">Total order price</h5>
            <p class="card-text text-muted">{{$total}}</p>
            <form action="{{ route('payments.process', $orderId) }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $orderId }}"> {{-- Asegúrate de pasar este dato desde el controlador --}}
                <button type="submit" class="btn btn-primary mt-3">Pay with Stripe</button>
            </form>

        </div>
    @endif
</div>
@endsection 