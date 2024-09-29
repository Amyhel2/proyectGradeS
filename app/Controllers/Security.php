<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Security extends BaseController
{
    public function get_csrf_token()
    {
        // Devolver el token CSRF
        return $this->response->setJSON([
            'csrf_token' => csrf_hash()
        ]);
    }

    
}
