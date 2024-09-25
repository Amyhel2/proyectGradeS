<?php

namespace App\Controllers;
use CodeIgniter\Files\File;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\DetectionModel;
use App\Models\NotificationModel;

class Notifications extends BaseController
{
    

    public function index()
    {
        $notificationModel = new NotificationModel();
        $data['notificaciones'] = $notificationModel->findAll(); // Trae todas las notificaciones

        return view('notifications/index', $data);  // Carga la vista con los datos
    }

    public function recibir()
    {
        // Recibimos los datos JSON enviados desde el servidor Flask
        $json = $this->request->getJSON(true);

        // Verificamos si se detectó un criminal
        if (isset($json['criminal_detected']) && $json['criminal_detected'] === true) {
            // Obtener detalles del criminal y el oficial
            $nombreCriminal = $json['nombre_criminal'];
            $oficial_id = $this->getOficialId();
            $criminal_id = $this->getCriminalId($nombreCriminal);

            if ($criminal_id && $oficial_id) {
                // Insertar en la tabla de detecciones
                $detectionModel = new DetectionModel();
                $detectionData = [
                    'criminal_id' => $criminal_id,
                    'oficial_id' => $oficial_id,
                    'fecha_deteccion' => date('Y-m-d H:i:s'),
                    'ubicacion' => 'Ubicación no especificada', // Aquí puedes agregar la ubicación real si está disponible
                    'confianza' => 0.95 // Nivel de confianza
                ];
                $detectionModel->insert($detectionData);

                // Insertar en la tabla de notificaciones
                $notificationModel = new NotificationModel();
                $notificationData = [
                    'deteccion_id' => $detectionModel->getInsertID(),
                    'oficial_id' => $oficial_id,
                    'mensaje' => "¡Atención! Se ha detectado al criminal: " . $nombreCriminal,
                    'fecha_envio' => date('Y-m-d H:i:s'),
                    'estado' => 'enviada'
                ];
                $notificationModel->insert($notificationData);

                return $this->respond(['status' => 'success', 'message' => 'Notificación enviada'], 200);
            } else {
                return $this->respond(['status' => 'error', 'message' => 'Criminal o oficial no encontrado'], 404);
            }
        } else {
            return $this->respond(['status' => 'success', 'message' => 'No se detectó ningún criminal'], 200);
        }
    }


    

    private function getOficialId()
    {
        // Método para obtener el ID del oficial actual desde la sesión o algún identificador
        return session()->get('userid'); // Ejemplo, reemplaza con tu lógica
    }

    private function getCriminalId($nombreCriminal)
    {
        // Obtener el ID del criminal basado en el nombre
        $db = \Config\Database::connect();
        $builder = $db->table('criminals');  // Reemplaza con el nombre real de tu tabla
        $criminal = $builder->where('nombre', $nombreCriminal)->get()->getRow();

        if ($criminal) {
            return $criminal->id;  // Retorna el ID del criminal encontrado
        } else {
            return null;  // Maneja el caso en que no se encuentra el criminal
        }
    }
}


