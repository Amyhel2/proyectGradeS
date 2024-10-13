<?php

namespace App\Controllers;

use CodeIgniter\Files\File;
use App\Controllers\BaseController;
use App\Models\CriminalsModel;
use App\Models\FotosModel;

class Maps extends BaseController
{
    public function showMap($lat, $long)
    {
        // Preparamos las coordenadas y las pasamos a la vista
        $data = [
            'lat' => $lat,
            'long' => $long
        ];
        
        // Retorna la vista que mostrará el mapa
        return view('detections/maps', $data);
    }

    
    
}
