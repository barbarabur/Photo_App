

Paso 1: Instalar el paquete JWT-Auth
Ejecuta el siguiente comando en la terminal dentro de tu proyecto Laravel:


composer require tymon/jwt-auth
Después, publica la configuración del paquete:

sh

php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
Esto generará el archivo de configuración en config/jwt.php.

🔹 Paso 2: Generar la clave secreta JWT
Ejecuta este comando para generar la clave secreta que usará JWT para firmar los tokens:


php artisan jwt:secret
Este comando modificará el archivo .env y añadirá una clave como esta:


JWT_SECRET=tu_clave_secreta_generada

🔹 Paso 3: Configurar el Modelo User.php
Abre app/Models/User.php y asegúrate de que implemente la interfaz JWTSubject y sus métodos:


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // Métodos requeridos por JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
🔹 Paso 4: Configurar auth.php para usar JWT
En config/auth.php, cambia el driver de autenticación a jwt en la configuración guards:


'guards' => [
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
'defaults' => [
    'guard' => env('AUTH_GUARD', 'web'),
    'passwords' => 'users',
    ],

    En .env
    AUTH_GUARD=web

🔹 Paso 5: Crear el AuthController
Ejecuta este comando para generar el controlador:


php artisan make:controller AuthController

Luego, edita app/Http/Controllers/AuthController.php 


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Método para registrar un usuario
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    // Método para iniciar sesión
    public function login()
{
        $credentials = request(['email', 'password']);

        if (! $token = auth(api)->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
        }

    // Método para cerrar sesión
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }

    // Obtener usuario autenticado
    public function me()
    {
        return response()->json(JWTAuth::user());
    }
}
🔹 Paso 6: Definir Rutas en routes/api.php
Añade las rutas para el registro, login y logout en routes/api.php:


use App\Http\Controllers\AuthController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});
