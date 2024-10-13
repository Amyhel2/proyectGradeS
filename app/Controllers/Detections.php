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

        $datos['detecciones'] = $detecciones; // Trae todas las detecciones con nombres de criminales

        return view('detections/index', $datos); // Carga la vista con los datos
    }

    public function almacenarDeteccion($criminalId, $deviceId)
{
    $modelo = new DetectionModel();
    $gafaModel = new GafasModel();

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
    $foto_deteccion = $this->request->getPost('foto_deteccion') ?? null;

    // Validar los valores recibidos
    if (empty($confianza) || empty($latitud) || empty($longitud) || empty($foto_deteccion)) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Datos incompletos proporcionados.']);
    }

    // Datos de la detección
    $data = [
        'criminal_id' => $criminalId,
        'oficial_id' => $oficialId,
        'fecha_deteccion' => date('Y-m-d H:i:s'),
        'ubicacion' => "$latitud, $longitud",
        'confianza' => $confianza,
    ];

    // Intentar insertar la detección en la base de datos
    try {
        // Inserta la detección y obtiene el ID de detección
        $modelo->insert($data);
        $idDeteccion = $modelo->insertID(); // Obtiene el ID de la última inserción

        // Extraer el nombre del criminal del nombre del archivo
        $partes_nombre = explode("_", basename($foto_deteccion)); // Obtener solo el nombre de la imagen sin la ruta
        array_shift($partes_nombre); // Eliminar el primer elemento (ID)
        $nombre_criminal = implode("_", $partes_nombre); // Unir el resto como nombre del criminal

        // Obtener la extensión del archivo
        $extension = pathinfo($foto_deteccion, PATHINFO_EXTENSION);

        // Crear el nuevo nombre en el formato idDeteccion_nombreCriminal.extensión
        $nuevo_nombre_foto = "{$idDeteccion}_{$nombre_criminal}";

        // Guardar el nuevo nombre en la base de datos
        $modelo->update($idDeteccion, ['foto_deteccion' => $nuevo_nombre_foto]); // Actualizar con el nuevo nombre

        return $this->response->setJSON(['status' => 'success', 'message' => 'Detección almacenada correctamente.']);
    } catch (\Exception $e) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Error al almacenar la detección: ' . $e->getMessage()]);
    }
}

}

