

Un trait es una forma de compartir funcionalidades entre clases sin necesidad de herenc
ESe guarda como un archivo de clase normal en app/Traits

<?php

namespace App\Traits; 


use Illuminate\Support\Facades\Auth;

trait AuthUser
{
    /**
     * Obtiene el usuario autenticado.
     *
     * @return \App\Models\User
     */

    public function getAuthUser()
    {
        return Auth::user();
    }
}

?>

Despues se usa el trait en un controlador sustituyendo las lineas de código.
<?php

namespace App\Models;

  // Incluimos el trait
use App\Traits\AuthUser;

class User
{
    public function loquesea(){
        $user = $this->getAuthUser();
    }
}
?>

