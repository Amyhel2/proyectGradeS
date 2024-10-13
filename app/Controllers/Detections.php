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
            ->select('detections.*, criminales.nombre AS criminal_nombre')
            ->join('criminales', 'criminales.idCriminal = detections.criminal_id')
            ->findAll();

        $datos['detecciones'] = $detecciones; // Trae todas las detecciones con nombres de criminales

        return view('detecciones/index', $datos); // Carga la vista con los datos
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

        // Obtener el porcentaje de confianza, latitud, longitud y foto_deteccion desde la solicitud
        $confianza = $this->request->getPost('confianza') ?? null;
        $latitud = $this->request->getPost('latitud') ?? null;
        $longitud = $this->request->getPost('longitud') ?? null;
        $foto_deteccion = $this->request->getPost('foto_deteccion') ?? null; // Obtener la nueva variable

        // Validar los valores recibidos
        if (empty($confianza) || empty($latitud) || empty($longitud) || empty($foto_deteccion)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Datos incompletos proporcionados.']);
        }

        // Datos de la detección
        $data = [
            'criminal_id' => $criminalId,
            'oficial_id' => $oficialId, // Asignar el oficial_id obtenido
            'fecha_deteccion' => date('Y-m-d H:i:s'), // Fecha y hora actual
            'ubicacion' => "Latitud: $latitud, Longitud: $longitud", // Guardar la ubicación
            'confianza' => $confianza, // Guardar el porcentaje de confianza
            'foto_deteccion' => $foto_deteccion, // Guardar la ruta de la imagen detectada
        ];

        // Intentar insertar la detección en la base de datos
        if ($modelo->insert($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Detección almacenada correctamente.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Error al almacenar la detección.']);
        }
    }
}
