@if(auth()->check())
    @if(auth()->user()->hasRole('Photographer'))
        <!-- Opción para editar -->
        <a href="{{ route('photos.edit', $photo->id) }}" class="btn btn-warning mb-3">Editar</a>
    @elseif(auth()->user()->hasRole('Client'))
        <!-- Opción para agregar a la orden -->
        <form action="{{ route('orders.add', $photo->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-success mb-3">Añadir a la orden</button>
        </form>
    @endif
@else
    <p>No estás autenticado. Inicia sesión para realizar acciones.</p>
@endif




VISTAS
resources/
  views/
    layouts/
      app.blade.php    // Layout principal
    partials/
      header.blade.php // Componentes reutilizables
    home.blade.php     // Vista principal
    users/
      index.blade.php  // Vista para listar usuarios
      show.blade.php   // Vista para mostrar un usuario


para crear las vistas: 
-> touch resources/views/welcome.blade.php
-> touch resources/views/header.blade.php
-> touch resources/views/footer.blade.php

código vistas:
// resources/views/header.blade.php
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Web</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <header class="bg-primary text-white text-center py-3">
        <h1>Enterprise Web</h1>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Inicio</a>
            <a class="navbar-brand" href="/productos">Productos</a>
            <a class="navbar-brand" href="/producto">Producto</a>
        </div>
    </nav>
</body>
</html>

// resources/views/footer.blade.php
<footer class="bg-dark text-white text-center py-3 mt-4">
    <p>&copy; 2025 Enterprise Web. Todos los derechos reservados.</p>
</footer>

// resources/views/welcome.blade.php
@include('header')
<div class="container mt-4">
    <h2 class="text-center">Bienvenido a la página principal</h2>
    <p class="text-center">Esta es la página de inicio de nuestro sitio web.</p>
</div>
@include('footer')


se crean las rutas:

Route::get('/', function () { return view('welcome'); }); Route::get('/productos', [ProductoController::class, 'index']); Route::get('/producto', [ProductoController::class, 'show']);

Controlador:
app/Http/Controllers/ProductoController.php:
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = [
            ['id' => 1, 'nombre' => 'Laptop', 'precio' => 1200],
            ['id' => 2, 'nombre' => 'Teléfono', 'precio' => 800],
            ['id' => 3, 'nombre' => 'Tablet', 'precio' => 500]
        ];
        
        return view('productos', compact('productos'));
    }

    public function show()
    {
        $producto = ['id' => 1, 'nombre' => 'Laptop', 'precio' => 1200, 'descripcion' => 'Laptop de última generación'];

        return view('producto', compact('producto'));
    }
}



