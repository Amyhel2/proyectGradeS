<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\DetectionModel;


class Detections extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $detectionModel = new DetectionModel();
        $data['detecciones'] = $detectionModel->findAll(); // Trae todas las detecciones

        return view('detections/index', $data);  // Carga la vista con los datos
    }

    

    
}






