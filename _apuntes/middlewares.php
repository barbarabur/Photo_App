
php artisan make:middleware NombredelMiddleware    ------> app/http/middleware


//registrar el middleware en Kernel.php

array Middleware - Se ejecuta en cada petición o ruta

Middleware groups - Array donde se pueden añadir varios middleware. Se ejecutan todos los mw que contiene el grupo cada vez que se llama a una de las rutas del grupo.

middleware Aliases- Se le de da un alias unico para llamarlo


// ponerlo en la ruta:

        Route::get('/photos/{photo}', [PhotoController::class, 'show'])
         ->middleware(['count.views']);

// si es una ruta que sale de resource en vez de get se pone en el controlador directamente:

        public function __construct()
        {
            $this->middleware('count.views')->only('show');
        }

 //opcion 2 en routes web:

// Ruta individual para 'show' con middleware
Route::get('/photos/{photo}', [PhotoController::class, 'show'])
    ->middleware('count.views')->name('photos.show');

// Y luego las demás rutas (sin duplicar 'show')
Route::resource('photos', PhotoController::class)->except(['show']);
