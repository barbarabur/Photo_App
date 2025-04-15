<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type'
    ];
//relacion 1:N con User para saber quien dio el like
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relación polimórfica el like puede ser a User o a Photo
    public function likeable()
    {
        return $this->morphTo();
    }
}
