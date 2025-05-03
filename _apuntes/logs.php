config/logging.php 

<?php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['single'], // Puedes agregar otros canales si lo necesitas
    ],
    
    'single' => [
        'driver' => 'single',
        'path' => storage_path('logs/laravel.log'),
        'level' => 'debug',
    ],

    // Otras configuraciones de log como daily, slack, etc.
],
?>

En los controladores:

Index()        Log::info('Navegación: Se accedió al listado de usuarios.');
create()       Log::info('Navegación: Se accedió al formulario de creación de usuario.');
store()         try {
                            Log::info('Creación: Se está intentando crear un nuevo usuario.', ['data' => $request->all()]);
                    } catch (\Exception $e) {
                        Log::error('Error: Error al crear el usuario.', ['exception' => $e->getMessage()]);
                        return redirect()->route('users.index')->with('error', 'Hubo un error al crear el usuario.');
                    }
edit()          Log::info('Navegación: Se accedió al formulario de edición de usuario.', ['user_id' => $id]);

destroy()       try {
                    Log::info('Eliminación: Se está intentando eliminar el usuario.', ['user_id' => $id]);
                        ......
                        Log::info('Eliminación: Usuario eliminado correctamente.', ['user_id' => $id]);
                } catch (\Exception $e) {
                    Log::error('Error: Error al eliminar el usuario.', ['exception' => $e->getMessage()]);
                    return redirect()->route('users.index')->with('error', 'Hubo un error al eliminar el usuario.');
                }



Se crea un LogController
<?php
use Illuminate\Support\Facades\File;

 public function index()
 {
     // Ruta del archivo de logs
     $logFile = storage_path('logs/laravel.log');

     if (File::exists($logFile)) {
         $logs = File::get($logFile);
     } else {
         $logs = 'No hay logs disponibles.';
     }

     return view('logs.index', compact('logs'));
 }
?>

en routes/web
Route::get('/logs', [LogController::class, 'index']);

