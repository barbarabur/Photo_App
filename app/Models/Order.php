<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_price',
        'user_id',
        'status'
    ];

    //relación 1:N user 
    public function user () 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //relacion order n:m photo
    public function photos()
    {
        return $this->belongsToMany(Photo::class, 'order_photo')
        ->withPivot('order_id', 'photo_id') 
        ->withTimestamps();
    }

      //relación order 1:1 payment
      public function payment () 
      {
          return $this->hasOne(Payment::class);
      }

}
