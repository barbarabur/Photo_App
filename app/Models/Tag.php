<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    
    protected $fillable = [
        'tag'
    ];

    //relación photo N:M tags
    public function photos () 
    {
        return $this->belongsToMany(Photo::class, 'photo_tag', 'tag_id', 'photo_id');
    }
}
