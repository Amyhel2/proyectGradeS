<?php 

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;
use App\Models\GafasModel;
use App\Models\CriminalsModel;
use App\Models\DetectionModel;
use App\Models\UsersModel;
use Twilio\Rest\Client;

class Notifications extends BaseController
{
    protected $notificationModel;
    protected $gafasModel;
    protected $usersModel;
    protected $detectionModel;
    protected $criminalsModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
        $this->gafasModel = new GafasModel();
        $this->usersModel = new UsersModel();
        $this->detectionModel = new DetectionModel(); // Cambio aquí
        $this->criminalsModel = new CriminalsModel(); // Cambio aquí
    }

    public function index()
    {
        try {
            $notificaciones = $this->notificationModel->findAll();
            
            foreach ($notificaciones as &$notificacion) {
                $oficial = $this->usersModel->find($notificacion['oficial_id']);
                if (!$oficial) {
                    echo "Oficial con ID {$notificacion['oficial_id']} no encontrado.\n";
                    continue;
                }
                $notificacion['nombre_oficial'] = "{$oficial['nombres']} {$oficial['apellido_paterno']} {$oficial['apellido_materno']}";
            }

            $data['notificaciones'] = $notificaciones;
            return view('notifications/index', $data);

        } catch (\Exception $e) {
            echo "Error al recuperar notificaciones: " . $e->getMessage();
            return view('errors/database_error');
        }
    }

    public function enviarNotificacionDeteccion($idDeteccion, $oficialId, $confianza, $latitud, $longitud, $foto_deteccion)
    {
        try {
            $usuario = $this->usersModel->find($oficialId);
            $deteccion = $this->detectionModel->find($idDeteccion);
            $oficialPhone = $usuario['celular'] ?? null;
            $criminal = $this->criminalsModel->find($deteccion['criminal_id']);
            $nombreCriminal = $criminal['nombre'] ?? 'Desconocido';

            if (empty($oficialPhone)) {
                throw new \Exception('Teléfono del oficial no disponible.');
            }

            $mensaje = "Criminal detectado: {$nombreCriminal}";

            // Guardar notificación en base de datos
            $notificationData = [
                'deteccion_id' => $idDeteccion,
                'oficial_id' => $oficialId,
                'mensaje' => $mensaje,
                'fecha_envio' => date('Y-m-d H:i:s'),
                'estado' => 'enviada',
            ];
            $this->notificationModel->insert($notificationData);

            // Enviar notificación por WhatsApp
            if (!$this->sendWhatsAppNotification($oficialPhone, $mensaje)) {
                throw new \Exception("Error en el envío de notificación por WhatsApp.");
            }

            // Enviar notificación de audio
            if (!$this->enviarTextoParaAudio($mensaje)) {
                throw new \Exception("Error en el envío de notificación de audio.");
            }

            echo "Notificación enviada correctamente.\n";
            return true;

        } catch (\Exception $e) {
            echo "Error al enviar la notificación: " . $e->getMessage();
            return false;
        }
    }

    private function sendWhatsAppNotification($phone, $message)
    {
        $sid = getenv('TWILIO_ACCOUNT_SID');
        $token = getenv('TWILIO_AUTH_TOKEN');
        $twilioNumber = getenv('TWILIO_PHONE_NUMBER');
        $client = new Client($sid, $token);

        try {
            $client->messages->create(
                'whatsapp:' . $phone, 
                [
                    'from' => 'whatsapp:' . $twilioNumber,
                    'body' => $message,
                ]
            );
            echo "Mensaje de WhatsApp enviado.\n";
            return true;
        } catch (\Exception $e) {
            echo 'Error al enviar WhatsApp: ' . $e->getMessage();
            return false;
        }
    }

    private function enviarTextoParaAudio($mensaje)
    {
        $url = "http://localhost:5000/generar-audio";  
        $data = ['mensaje' => $mensaje];
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {
            echo "Notificación de audio enviada correctamente.\n";
            return true;
        } else {
            echo "Error al enviar la notificación de audio. Código de estado: {$httpCode}\n";
            return false;
        }
    }
}
