<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'url',
        'price',
        'user_id',
        'views',
    ];

    //relacion user upload photo 1:N
    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //relación photo N:M order
    public function orders () 
    {
        return $this->belongsToMany(Order::class);
    }

     //relación photo N:M tag
     public function tags () 
     {
        return $this->belongsToMany(Tag::class,  'photo_tag', 'photo_id', 'tag_id');
     }
     
     //relacion polimorfica user likes photo N:M
     public function likedByUsers() 
     {
        return $this->morphToMany(User::class, 'likeable', 'likes');
     }

     public function likes()
{
    return $this->morphMany(Like::class, 'likeable');
}


    //relacion polimorfica user comments photo n:M
    public function commentedByUsers() 
    {
        return $this->morphToMany(User::class, 'commentable', 'comments');
    }
 
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
     
}

  

  