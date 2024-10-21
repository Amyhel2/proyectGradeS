<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetectionModel;
use App\Models\GafasModel;
use App\Models\CriminalsModel;
use App\Controllers\Notifications;

class Detections extends BaseController
{
    protected $detectionModel;
    protected $gafasModel;
    protected $criminalsModel;
    protected $notifications;

    public function __construct()
    {
        $this->detectionModel = new DetectionModel();
        $this->gafasModel = new GafasModel();
        $this->criminalsModel = new CriminalsModel();
        $this->notifications = new Notifications();
    }

    public function index()
    {
        $datos['detecciones'] = $this->detectionModel->getDetections();
        return view('detections/index', $datos);
    }

    public function almacenarDeteccion($criminalId, $deviceId)
    {
        // Obtener oficial_id a partir del device_id
        $gafa = $this->gafasModel->where('device_id', $deviceId)->first();
        $oficialId = $gafa['oficial_id'] ?? null;

        if (empty($criminalId) || empty($oficialId)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID de criminal u oficial inválido.']);
        }

        // Obtener los datos de la solicitud
        $confianza = $this->request->getPost('confianza');
        $latitud = $this->request->getPost('latitud');
        $longitud = $this->request->getPost('longitud');
        $foto_deteccion = $this->request->getPost('foto_deteccion');

        if (empty($confianza) || empty($latitud) || empty($longitud) || empty($foto_deteccion)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Datos incompletos.']);
        }

        // Almacenar detección en la base de datos
        $data = [
            'criminal_id' => $criminalId,
            'oficial_id' => $oficialId,
            'fecha_deteccion' => date('Y-m-d H:i:s'),
            'ubicacion' => "$latitud, $longitud",
            'confianza' => $confianza,
            'foto_deteccion' => $foto_deteccion
        ];

        try {
            $this->detectionModel->insert($data);
            $idDeteccion = $this->detectionModel->insertID();

            // Procesar la imagen
            $this->procesarImagenDeteccion($foto_deteccion, $idDeteccion);

            // Enviar notificación
            $this->notifications->enviarNotificacionDeteccion($idDeteccion, $oficialId, $confianza, $latitud, $longitud, $foto_deteccion);

            return $this->response->setJSON(['status' => 'success', 'message' => 'Detección almacenada correctamente.']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Error al almacenar la detección: ' . $e->getMessage()]);
        }
    }

    private function procesarImagenDeteccion($foto_deteccion, $idDeteccion)
    {
        $nombre_original = basename($foto_deteccion);
        $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
        $nuevo_nombre_foto = "{$idDeteccion}_{$nombre_original}";

        $ruta_imagen_temp = "C:/xampp/htdocs/proyectGradeS/public/uploads/ImagenesCriminalesDetectados/{$foto_deteccion}";
        $ruta_imagen_destino = "C:/xampp/htdocs/proyectGradeS/public/uploads/ImagenesCriminalesDetectados/{$nuevo_nombre_foto}";

        if (!@rename($ruta_imagen_temp, $ruta_imagen_destino)) {
            throw new \Exception('Error al mover la imagen detectada.');
        }

        $this->detectionModel->update($idDeteccion, ['foto_deteccion' => $nuevo_nombre_foto]);
    }

    public function verImagenDetectada($idDeteccion)
    {
        $deteccion = $this->detectionModel->find($idDeteccion);

        if (!$deteccion) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Detección no encontrada');
        }

        $criminal = $this->criminalsModel->find($deteccion['criminal_id']);

        return view('detections/images', [
            'foto_deteccion' => $deteccion['foto_deteccion'],
            'fecha_deteccion' => $deteccion['fecha_deteccion'],
            'criminal' => $criminal
        ]);
    }
}
