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
    protected $userId;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
        $this->gafasModel = new GafasModel();
        $this->usersModel = new UsersModel();
        $this->detectionModel = new DetectionModel(); // Cambio aquí
        $this->criminalsModel = new CriminalsModel(); // Cambio aquí
        $this->userId = session()->get('userid');
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

    
    public function enviarTextoParaAudio($mensaje) {
        $urlServidorFlask = 'http://192.168.100.16:5000/generar_audio_notificacion';
    
        $data = [
            'mensaje' => $mensaje
        ];
    
        $ch = curl_init($urlServidorFlask);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    
        $respuesta = curl_exec($ch);
    
        if ($respuesta === false) {
            echo "Error al enviar el mensaje al servidor Flask: " . curl_error($ch);
            curl_close($ch);
            return false;
        }
    
        curl_close($ch);
        echo "Mensaje enviado al servidor Flask para conversión a audio.\n";
        return true;
    }
    
    public function loadNavbar()
    {
        // Obtener el conteo de notificaciones no leídas
        $unreadCount = $this->notificationModel->getUnreadNotificationsCount($this->userId);
        $notifications = $this->notificationModel->getUnreadNotifications($this->userId);

        // Pasar los datos a la vista
        return view('dashboard/header', [
            'unreadCount' => $unreadCount,
            'notifications' => $notifications
        ]);
    }
    
}
