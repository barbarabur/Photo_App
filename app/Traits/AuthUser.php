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
