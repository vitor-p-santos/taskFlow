<?php

namespace App\Http\Controllers;

use App\Trait\ResponseTrait;

abstract class Controller{

    use ResponseTrait;

    protected function getCookie($name, $token)
    {
        return cookie(
            $name,
            $token,
             20160 * 60,
            '/',
            null,
            false, // true em produção com HTTPS
            true,  // HttpOnly
            false,
            'Lax'
        );
    }
}