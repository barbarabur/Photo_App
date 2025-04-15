<?php
//Estructura básica del modelo

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class MiModelo extends Model
{
    use HasFactory;

    protected $fillable = [
        'atributos de la tabla',
        'por orden',
        'salvo el id',
    ]; // Atributos editables

    //Relacion 1:1 User-Profile
    // En User:
public function profile()
{
    return $this->hasOne(Profile::class);
}

// En Profile:
public function user()
{
    return $this->belongsTo(User::class);
}
// clave foranea en profiles clients_id

//Relacion 1:N User-Post
// En User:
public function posts()
{
    return $this->hasMany(Post::class);
}

// En Post:
public function user()
{
    return $this->belongsTo(User::class);
}
// Clave foránea: posts.user_id.

//Relacion N:M role-user sin atributos en la relacion hay que hacer tabla pivote pero sin modelo
// Migraciones:
Schema::create('roles', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});

Schema::create('role_user', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('role_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});

//modelos
class User extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}

class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

//con atributos en tabla pivot
Schema::create('order_product', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained()->onDelete('cascade');
    $table->foreignId('product_id')->constrained()->onDelete('cascade');
    $table->integer('quantity');
    $table->decimal('price', 8, 2);
    $table->timestamps();
});



//modelo intermedio
class OrderProduct extends Model
{
    protected $table = 'order_product';
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];
}

//en modelos
class Order extends Model
{
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price')->withTimestamps();
    }
}

class Product extends Model
{
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price')->withTimestamps();
    }
}


// n:m polimorfica

//migracion
Schema::create('likes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->morphs('likable'); // Crea las columnas `likable_id` y `likable_type`
    $table->timestamps();
});

//modelos

class User extends Model
{
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}

class Like extends Model
{
    public function likable()
    {
        return $this->morphTo();
    }
}

class Photo extends Model
{
    public function likes()
    {
        return $this->morphToMany(User::class, 'likable');
    }
}

class User extends Model
{
    public function likes()
    {
        return $this->morphToMany(User::class, 'likable');
    }
}





?>