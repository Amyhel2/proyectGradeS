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

    public function almacenarDeteccion($criminalId)
    {
        $modelo = new DetectionModel();

        // Verificar si criminalId es válido (puedes implementar lógica adicional)
        if (empty($criminalId)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Criminal ID es inválido.']);
        }

        // Datos de la detección
        $data = [
            'criminal_id' => $criminalId,
            'fecha' => date('Y-m-d H:i:s'), // Fecha y hora actual
            'ubicacion' => 'Ubicación desconocida', // O puedes pasar una ubicación real si la tienes
        ];

        // Intentar insertar la detección en la base de datos
        if ($modelo->insert($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Detección almacenada correctamente.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Error al almacenar la detección.']);
        }
    }

    

    
}






