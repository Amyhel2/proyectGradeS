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
    $gafaModel = new GafasModel(); // Modelo de gafas

    // Obtener el oficial_id usando el device_id
    $gafa = $gafaModel->where('device_id', $deviceId)->first();
    $oficialId = $gafa['oficial_id'] ?? null;

    // Verificar si criminalId y oficialId son válidos
    if (empty($criminalId) || empty($oficialId)) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'ID de criminal u oficial inválido.']);
    }

    // Obtener los datos de la solicitud: confianza, latitud, longitud y la imagen detectada
    $confianza = $this->request->getPost('confianza') ?? null;
    $latitud = $this->request->getPost('latitud') ?? null;
    $longitud = $this->request->getPost('longitud') ?? null;
    $imagen_detectada = $this->request->getPost('imagen_detectada') ?? null;  // Imagen detectada

    // Validar el valor de confianza, latitud, longitud y la imagen
    if (empty($confianza) || empty($latitud) || empty($longitud) || empty($imagen_detectada)) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Datos insuficientes.']);
    }

    // Datos de la detección
    $data = [
        'criminal_id' => $criminalId,
        'oficial_id' => $oficialId,
        'fecha_deteccion' => date('Y-m-d H:i:s'),
        'ubicacion' => json_encode(['latitud' => $latitud, 'longitud' => $longitud]),
        'confianza' => $confianza,
        'imagen_detectada' => $imagen_detectada // Guardar la imagen detectada
    ];

    // Intentar insertar la detección en la base de datos
    if ($modelo->insert($data)) {
        return $this->response->setJSON(['status' => 'success', 'message' => 'Detección almacenada correctamente.']);
    } else {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Error al almacenar la detección.']);
    }
}


    
}






