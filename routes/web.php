<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/layouts/stats', [PhotoController::class, 'stats'])->name('layouts.stats');


Route::resource('comments', CommentController::class);

Route::get('/photo/{id}/comments', [CommentController::class, 'show'])->name('photo.comments');
Route::get('/user/{id}/comments', [CommentController::class, 'showUserComments'])->name('user.comments');

Route::get('/clients/mainClient',[PhotoController::class, 'index'])->name('clients.mainClient');

Route::get('/clients/likes', [PhotoController::class, 'photosConLike'])->name('clients.likes');

Route::post('/clients/{photo}/likes', [PhotoController::class, 'like'])->name ('clients.like');

Route::get('/chart', [OrderController::class, 'photosInOrder'])->name('orders.photo');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/add-to-order/{photo}', [OrderController::class, 'addToOrder'])->name('order.add');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/users', UserController::class);
    
    // Ruta para el cliente (Client)
    Route::get('/mainClient', [PhotoController::class, 'index'])->name('clients.mainClient');
    
    // Ruta para el fotógrafo (Photographer)
    Route::get('/mainPhotos', [PhotoController::class, 'index'])->name('photos.mainPhoto');
    
    Route::get('/photos/sales', [PhotoController::class, 'completedOrderPhotos'])->name('photos.sales');
    
});
Route::resource('photos', PhotoController::class);
Route::get('/logs', [LogController::class, 'index']);

//ruta para el pago con stripe

Route::middleware('auth')->group(function () {
    Route::get('/payment/{order}', [PaymentController::class, 'showPaymentForm'])->name('payments.form');
    Route::post('/payment/{order}', [PaymentController::class, 'processPayment'])->name('payments.process');
});


// Incluyendo las rutas de autenticación
require __DIR__.'/auth.php';
