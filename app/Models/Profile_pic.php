<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile_pic extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'profile_pic',
        
    ];

    public function user () 
    {
        return $this->belongsTo(User::class);
    }
}
