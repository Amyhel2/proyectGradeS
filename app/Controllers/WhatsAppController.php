<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Services\TwilioService;

use CodeIgniter\Controller;

class WhatsappController extends BaseController
{
    public function index()
    {
        // Cargar la vista del formulario
        return view('send_whatsapp_message');
    }

    public function send()
    {
        // Validar los datos enviados por el formulario
        $number = $this->request->getPost('number');
        $message = $this->request->getPost('message');

        if ($number && $message) {
            // Crear instancia del servicio de Twilio
            $twilioService = new TwilioService();

            // Enviar el mensaje de WhatsApp
            $result = $twilioService->sendWhatsAppMessage($number, $message);

            // Pasar el resultado a la vista para mostrarlo
            return view('send_whatsapp_message', ['result' => $result]);
        } else {
            return view('send_whatsapp_message', ['result' => 'Error: Faltan campos.']);
        }
    }
}

