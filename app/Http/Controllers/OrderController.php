<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Photo;
use App\Models\User;
use App\Traits\LogsUserActivity;


use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    use LogsUserActivity;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('order.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo_ids' => 'required|array',
            'photo_ids.*' => 'exists:photos,id'
        ]);

        $total = Photo::whereIn('id', $request->photo_ids)->sum('price');

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $total,
            'status' => 'pending'
        ]);

        $order->photos()->attach($request->photo_ids);

        return redirect()->route('orders.index')->with('success', 'Order created.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with('photos', 'user')->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $photos = Photo::all();
        return view('orders.edit', compact('order', 'photos'));        

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**´
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->photos()->detach();
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');    }

    public function addToOrder (Request $request, $photoId) {
        $user = Auth::user();

        // Buscar una orden pendiente para este usuario
        $order = Order::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'pending'],
            ['total_price' => 0] 
        );
        // Verificar si la foto ya está en la orden
        if (!$order->photos->contains($photoId)) {
            $order->photos()->attach($photoId);

            $photo = Photo::findOrFail($photoId);
            $order ->total_price+= $photo->price;
            $order->save();
        }
        $this->logActivity('Foto añadida al carrito', ['photo_id' => $photoId]);

        return redirect()->back()->with('success', 'Foto añadida a la orden.');

    }

    public function photosInOrder ()
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)
        ->where('status', 'pending')
        ->with('photos')
        ->first();

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'No hay órdenes pendientes');
        }

        $photos = $order->photos;
        $total = $photos->sum('price');
        $orderId = $order->id;
    
        return view('clients.chart', compact('photos', 'total', 'orderId'));
    }

    

}  
