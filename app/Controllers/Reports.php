<?php

namespace App\Controllers;

use App\Models\CriminalsModel;
use App\Models\DetectionModel;
use App\Models\UsersModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Reports extends BaseController
{
    public function index()
    {
        //
        return view('reports/index');
    }
    public function detalleCriminal($criminalId)
    {
        $criminalModel = new CriminalsModel();
        $detectionModel = new DetectionModel();
        $userModel = new UsersModel();

        // Obtener la información del criminal
        $data['criminal'] = $criminalModel->find($criminalId);
        
        // Obtener la información de la detección más reciente para este criminal
        $data['deteccion'] = $detectionModel->where('criminal_id', $criminalId)->orderBy('fecha_deteccion', 'DESC')->first();

        // Obtener la información del oficial que realizó la detección
        $data['oficial'] = $userModel->find($data['deteccion']['oficial_id']);
        
        return view('reports/index', $data);
    }

    
}
