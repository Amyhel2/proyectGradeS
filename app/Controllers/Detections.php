<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\DetectionModel;
use App\Models\GafasModel;

class Detections extends BaseController
{
    

    public function index()
{
    $detectionModel = new DetectionModel();
    
    // Realiza la unión con la tabla de criminales
    $detecciones = $detectionModel
        ->select('detections.*, criminals.nombre AS criminal_nombre')
        ->join('criminals', 'criminals.idCriminal = detections.criminal_id')
        ->findAll();

    $data['detecciones'] = $detecciones; // Trae todas las detecciones con nombres de criminales

    return view('detections/index', $data);  // Carga la vista con los datos
}

public function almacenarDeteccion($criminalId, $deviceId)
{
    $modelo = new DetectionModel();
    $gafaModel = new GafasModel(); // Asegúrate de que el modelo de gafas esté disponible

    // Obtener el oficial_id usando el device_id
    $gafa = $gafaModel->where('device_id', $deviceId)->first();
    $oficialId = $gafa['oficial_id'] ?? null;

    // Verificar si criminalId y oficialId son válidos
    if (empty($criminalId) || empty($oficialId)) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'ID de criminal u oficial inválido.']);
    }

    // Obtener el porcentaje de confianza desde la solicitud
    $confianza = $this->request->getPost('confianza') ?? null;

    // Validar el valor de confianza
    if (empty($confianza)) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Confianza no proporcionada.']);
    }

    // Datos de la detección
    $data = [
        'criminal_id' => $criminalId,
        'oficial_id' => $oficialId, // Asignar el oficial_id obtenido
        'fecha' => date('Y-m-d H:i:s'), // Fecha y hora actual
        'ubicacion' => 'Ubicación desconocida', // O puedes pasar una ubicación real si la tienes
        'confianza' => $confianza, // Guardar el porcentaje de confianza
    ];

    // Intentar insertar la detección en la base de datos
    if ($modelo->insert($data)) {
        return $this->response->setJSON(['status' => 'success', 'message' => 'Detección almacenada correctamente.']);
    } else {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Error al almacenar la detección.']);
    }
}




    

    
}






