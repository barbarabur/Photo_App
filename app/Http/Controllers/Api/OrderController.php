<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Photo;
use App\Traits\LogsUserActivity;

use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    use LogsUserActivity;

    public function index()
    {
        $orders = Order::all();
        return response()->json($orders, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo_ids' => 'required|array',
            'photo_ids.*' =>'exists:photos,id'
        ]);

        $total = Photo::whereIn('id', $request->photo_ids)->sum('price');

        $order = Order::create([
            'user_id'=> Auth::id(),
            'total_price'=>$total,
            'status'=> 'pending'
        ]);

        $order->photos()->attach($request->photo_ids);

        return response()-> json([
        'message'=> 'Orden creada correctamente',
            'order'=> $order,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with('photos', 'user')->find($id);
        if(!$order) {
            return response()->json(['message' => 'foto no encontrada'], 404);
        }

        return response()->json($order, 200);
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        $request->validate([
            'status' => 'in:pending,completed,cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Orden actualizada'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order= Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        $order->photos()->detach();
        $order->delete();

        return response()->json(['message' => 'Order borrada correctamente'], 200);
    }
}
