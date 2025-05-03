-- Instalamos el paquete, publicamos la configuración y generamos la clave para los tokens:

composer require tymon/jwt-auth

php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret  //Esto agregará la clave JWT_SECRET al archivo .env.

--En models/user.php

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    //para incluir roles o permisos personalizados:
    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->getRoleNames(), // Devuelve un array de roles asignados
            'permissions' => $this->getAllPermissions()->pluck('name'), // Array de permisos
        ];
    }
}

-- En config/auth.php
'guards' => [
        'web' => [
            ...
        ],
        'api' => [
            'driver' =>'jwt',
            'provider' => 'users',
        ]
    ],

    
    -- crear un controlador api/AuthController
    php artisan make:controller API/AuthController
    
    namespace App\Http\Controllers\API;
    
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Tymon\JWTAuth\Facades\JWTAuth;
    
    class AuthController extends Controller
    {
        public function login(Request $request)
        {
            $credentials = $request->only('email', 'password');
            
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            
            return $this->respondWithToken($token);
        }
        
        public function me()
        {
            return response()->json(auth()->user());
        }
        
        public function logout()
        {
            auth()->logout();
            return response()->json(['message' => 'Successfully logged out']);
        }
        
        public function refresh()
        {
            return $this->respondWithToken(auth()->refresh());
        }
        
        protected function respondWithToken($token)
        {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                ]);
            }
        }
        
        -- incluir esto en routes/api
        Route::middleware(['auth:api'])->group(function () {
            Route::get('/user', function () {
                return auth()->user();
            });
        });

        Route::prefix('auth')->group(function () {
    Route::post('login', [\App\Http\Controllers\API\AuthController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\API\AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [\App\Http\Controllers\API\AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('me', [\App\Http\Controllers\API\AuthController::class, 'me'])->middleware('auth:api');
});

-- En config/jwt.php, se puede ajustar:

'ttl' => 60, // Token válido por 60 minutos