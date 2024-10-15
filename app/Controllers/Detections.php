<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetectionModel;
use App\Models\GafasModel;
use App\Models\CriminalsModel;

class Detections extends BaseController
{
    public function index()
    {
        $detectionModel = new DetectionModel();

        $datos['detecciones'] = $detectionModel->getDetections(); // Obtener detecciones con nombres de oficiales

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
    
            // Crear el nuevo nombre en el formato idDeteccion_nombreCriminal.extensión
            $partes_nombre = explode("_", basename($foto_deteccion)); 
            array_shift($partes_nombre); // Eliminar el primer elemento (ID)
            $nombre_criminal = implode("_", $partes_nombre); // Unir el resto como nombre del criminal
            $extension = pathinfo($foto_deteccion, PATHINFO_EXTENSION);
            $nuevo_nombre_foto = "{$idDeteccion}_{$nombre_criminal}";
    
            // Mover el archivo temporal a su ruta final con el nuevo nombre
            $ruta_imagen_temp = "C:/xampp/htdocs/proyectGradeS/public/uploads/ImagenesCriminalesDetectados/{$foto_deteccion}";
            $ruta_imagen_destino = "C:/xampp/htdocs/proyectGradeS/public/uploads/ImagenesCriminalesDetectados/{$nuevo_nombre_foto}";
    
            if (!@rename($ruta_imagen_temp, $ruta_imagen_destino)) {
                throw new \Exception('Error al mover la imagen detectada.');
            }
    
            // Guardar el nuevo nombre de la imagen en la base de datos
            $modelo->update($idDeteccion, ['foto_deteccion' => $nuevo_nombre_foto]);
    
            return $this->response->setJSON(['status' => 'success', 'message' => 'Detección almacenada correctamente.']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Error al almacenar la detección: ' . $e->getMessage()]);
        }
    }
    


public function verImagenDetectada($idDeteccion)
{
    // Obtener la información de la detección basada en el ID
    $deteccionModel = new DetectionModel();
    $deteccion = $deteccionModel->find($idDeteccion);

    // Verificar si la detección existe
    if (!$deteccion) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Detección no encontrada');
    }

    // Obtener la información del criminal (si es necesario)
    $criminalModel = new CriminalsModel();
    $criminal = $criminalModel->find($deteccion['criminal_id']);

    // Pasar los datos a la vista
    return view('detections/images', [
        'foto_deteccion' => $deteccion['foto_deteccion'],
        'fecha_deteccion' => $deteccion['fecha_deteccion'],
        'criminal' => $criminal
    ]);
}


}

