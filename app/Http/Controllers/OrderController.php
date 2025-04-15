<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Photo;
use App\Models\User;


use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = Order::all();
        return view('chart.index', compact('chart'));
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
        return redirect()->route('photos.show', $request->commentable_id)->with('success', 'Comentario agregado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();


        $order =Order::find($id)->with('photos')->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }

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

        return redirect()->back()->with('success', 'Foto añadida a la orden.');

    }

    public function photosInOrder ()
    {
        $user = Auth::user();


        $order =Order::find() ->with('photos')->first();

        foreach ($order->photos as $photo) {
            // Acceder a los datos de la tabla pivote
            $quantity = $photo->pivot->quantity; // Ejemplo de acceso al valor quantity
            $status = $photo->pivot->status; // Ejemplo de acceso al valor status
        }
    
        return view('clients.chart', compact('order'));

    }
}
