hacemos la carpeta mkdir app/Traits y creamos dentro el archivo touch app/Traits/LogsUserActivity.php


<?php

namespace App\Traits;

trait HasTitleCase
{
    public function titleCase($string)
    {
        return ucwords(strtolower($string));
    }
}
?>


Despues se usa el trait en un controlador
<?php

use App\Traits\HasTitleCase;

// Crear una clase anónima con el trait
$instance = new class {
    use HasTitleCase;
};

echo $instance->titleCase('hola mundo desde laravel'); // Hola Mundo Desde Laravel
?>

new class {} crea una clase anónima (sin nombre).

Dentro de ella usamos el trait HasTitleCase.

Luego se puede usar el método titleCase() como si fuera parte de una clase normal.