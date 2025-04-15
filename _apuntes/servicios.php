MAIL:

GENERAR UNA CLASE CORREO 
-> php artisan make:mail NotificacionMailable


app/http/mail/NotificationMailable

<?php 
namespace App\Mail; 
use Illuminate\Bus\Queueable; 
use Illuminate\Contracts\Queue\ShouldQueue; 
use Illuminate\Mail\Mailable; 
use Illuminate\Queue\SerializesModels; 

class NotificacionMailable extends Mailable 
{ 
use Queueable, SerializesModels; 
public $subject = "Asunto del correo"; 
public $contenido; 
public function __construct($contenido) 
{ 
$this->contenido = $contenido;
 } 
public function build()
{ 
return $this->view('emails.notificacion');
 } 
}


crear servicio EmailService en app/services

<?php

namespace App\Services;

use App\Mail\NotificacionMailable;
use Illuminate\Contracts\Mail\Mailer;

class EmailService
{
   protected $mailer;

   public function __construct(Mailer $mailer)
   {
       $this->mailer = $mailer;
   }


   public function sendEmail($destinatario, $contenido)
   {
       $correo = new NotificacionMailable($contenido);
       $this->mailer->to($destinatario)->send($correo);
   }
}


crear un servicio FileService:

  <?php

  namespace App\Services;

  use Illuminate\Support\Facades\Storage;

  class FileService
  {
      public function saveFile($path, $contenido)
      {
          Storage::put($path, $contenido);
      }

      public function getFile($path)
      {
          return Storage::get($path);
      }

      public function deleteFile($path)
      {
          Storage::delete($path);
      }
  }



->  php artisan make:provider ServiciosProvider

app/Providers/serviciosProvider

  <?php

  namespace App\Providers;

  use Illuminate\Support\ServiceProvider;
  use App\Services\EmailService;
  use App\Services\FileService;

  class ServiciosProvider extends ServiceProvider
  {
      public function register()
      {
          $this->app->singleton(EmailService::class, function ($app) {
              return new EmailService();
          });

          $this->app->singleton(FileService::class, function ($app) {
              return new FileService();
          });
      }

      public function boot()
      {
          //
      }
  }


en config/app.php añadir 
'providers' => [ 
// Otros proveedores de servicios
 App\Providers\ServiciosProvider::class, 
],


en AuthController
use App\Services\EmailService;
class AuthController extends Controller
{
   protected $emailService;

   public function __construct(EmailService $emailService)
   {
       $this->emailService = $emailService;
   }

   public function register(Request $request)
   {
       // Lógica de registro de usuario

       // Enviar correo de bienvenida
       $this->emailService->sendEmail($request->email, 'Bienvenido a nuestra plataforma');

       // Resto de la lógica
   }}

En controlador CRUD

<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\Request;

class ArchivoController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function store(Request $request)
    {
        $contenido = $request->file('archivo')->get();
        $path = 'archivos/' . $request->file('archivo')->getClientOriginalName();

        $this->fileService->saveFile($path, $contenido);

        // Resto de la lógica
    }
}


API SERVICE


php artisan make:service loqueseaApiService

Crea el archivo app/Services/StarWarsApiService.php

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LodqueseaApiService
{
    public function getRandomAlgo()
    {
        $randomId = rand(1, 83);
        $response = Http::get("URLdelServicio{$randomId}");

        if ($response->successful()) {
            return $response->json()['result']['properties']['name'] ?? null;
        }

        return null;
    }
}