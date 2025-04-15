<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    protected $collection = 'comments';

    protected $fillable = [
        'user_id',
        'commentable_id',
        'commentable_type',
        'content'
    ];
    //relacion 1:N con User para saber quien hizo el comment
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relación polimórfica el coment puede ser a Comment o a Photo
    public function commentable()
    {
        return $this->morphTo();
    }

     //comentarios recibidos (reflexiva) en comment
     public function commentedOn()
     {
         return $this->morphMany(Comment::class, 'commentable');
     }
}
