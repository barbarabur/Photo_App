## Sesión 1

1. **Instalación de Bootstrap** :
   composer require laravel/ui && php artisan ui bootstrap
   npm install && npm run dev

2. **Instalación de Intervention image** :
  composer require intervention/image
  
This will install Intervention Image with the most recent version, your composer.json is automatically updated and you will be able use the package's classes via the autoloader. To do this you will need to require the just created vendor/autoload.php file to PSR-4 autoload all your installed composer packages.

require './vendor/autoload.php';
 
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

// create new manager instance with desired driver
$manager = new ImageManager(new Driver());