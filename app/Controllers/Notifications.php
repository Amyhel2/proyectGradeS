<?php 

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;
use App\Models\GafasModel;
use App\Models\UsersModel;
use Twilio\Rest\Client;

class Notifications extends BaseController
{
    protected $notificationModel;
    protected $gafasModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
        $this->gafasModel = new GafasModel();
    }

    public function index()
    {
        $data['notificaciones'] = $this->notificationModel->findAll();
        return view('notifications/index', $data);
    }

    public function enviarNotificacionDeteccion($idDeteccion, $oficialId, $confianza, $latitud, $longitud, $foto_deteccion)
{
    $notificationModel = new NotificationModel();
    $gafaModel = new GafasModel();
    $usersModel = new UsersModel();

    // Obtener el teléfono del oficial desde la tabla 'users'
    $usuario = $usersModel->where('id', $oficialId)->first();
    $oficialPhone = $usuario['celular'] ?? null;

    if (empty($oficialPhone)) {
        throw new \Exception('Teléfono del oficial no disponible.');
    }

    // Generar el mensaje de notificación
    $mensaje = "Criminal detectado. Confianza: {$confianza}%. Ubicación: {$latitud}, {$longitud}.";

    // Insertar notificación en la base de datos
    $notificationData = [
        'deteccion_id' => $idDeteccion,
        'oficial_id' => $oficialId,
        'mensaje' => $mensaje,
        'fecha_envio' => date('Y-m-d H:i:s'),
        'estado' => 'enviada',
    ];
    $notificationModel->insert($notificationData);

    // Enviar la notificación por WhatsApp
    $this->sendWhatsAppNotification($oficialPhone, $mensaje);
}

    private function sendWhatsAppNotification($phone, $message)
    {
        $sid = getenv('TWILIO_ACCOUNT_SID');
        $token = getenv('TWILIO_AUTH_TOKEN');
        $twilioNumber = getenv('TWILIO_PHONE_NUMBER');

        $client = new Client($sid, $token);

        $client->messages->create(
            'whatsapp:' . $phone, 
            [
                'from' => 'whatsapp:' . $twilioNumber,
                'body' => $message,
            ]
        );
    }
}
