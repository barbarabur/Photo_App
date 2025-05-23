<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;



class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
 
    
    //función para acceder al tipo de rol
        public function hasRole($role)
    {
        return $this->role === $role;
    }

    
    //relacion User 1:1 profile_pic
    public function profile_pic()
    {
        return $this->hasOne(Profile_pic::class);
    }
    
    //relacion user makes order 1:N
    
    public function orders()
    {
        return $this->hasMany(Order::class);  
    }

    //relacion user uploads 1:N photos
    public function photos ()
    {
    return $this ->hasMany(Photo::class, 'user_id');
    }
    
    //User-Comments N:M p
    //comentarios hechos por el usuario 
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    //user-Likes N:M
    //likes hechos por el usuario
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
    //likes recibidos (reflexiva)
    public function LikedOn()
    {
        return $this->morphMany(Like::class, 'likeable');
    }


    //Token y autenticacion. jwt
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
  
