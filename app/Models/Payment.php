<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        
    ];

    //relación order 1:1 payment
    public function order () 
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
