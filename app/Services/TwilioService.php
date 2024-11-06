<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $twilioSid;
    protected $twilioAuthToken;
    protected $twilioWhatsAppNumber;
    protected $client;

    public function __construct()
    {
        // Cargar las credenciales de Twilio desde el archivo .env
        $this->twilioSid = getenv('TWILIO_SID');
        $this->twilioAuthToken = getenv('TWILIO_TOKEN');
        $this->twilioWhatsAppNumber = getenv('TWILIO_WHATSAPP');
        $this->client = new Client($this->twilioSid, $this->twilioAuthToken);
    }

    public function sendWhatsAppMessage($to, $message)
    {
        try {
            $message = $this->client->messages->create(
                'whatsapp:' . $to, // Número de destino
                [
                    'from' => 'whatsapp:' . $this->twilioWhatsAppNumber,
                    'body' => $message
                ]
            );
            return $message->sid; // Devolver el SID del mensaje enviado
        } catch (\Exception $e) {
            return $e->getMessage(); // Manejar errores
        }
    }
}
