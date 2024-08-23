<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Galeria extends BaseController
{
    public function index()
    {
        //
        return view('upload/formulario');
    }

    public function subir()
    {
        //
        echo '<pre>';

        $file=$this->request->getFile('archivo');

        if(!$file->isValid()){

            echo $file->getErrorString();
            
            exit;
        }

        if(!$file->hasMoved()){

            $ruta = ROOTPATH. 'public/images';

           $file->move($ruta, 'Mi_image.png');
           
           echo "archivo cargado correctamente";
        }

        echo '</pre>';




        return view('upload/formulario');
    }
}
