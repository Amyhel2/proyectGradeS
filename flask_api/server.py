import requests
from flask import Flask, request, send_file
import os
import base64
from pydub import AudioSegment

app = Flask(__name__)

# API Key de Google Cloud Text-to-Speech
GOOGLE_API_KEY = "AIzaSyDNM2US7zU1EIcyntDeXnwXXV9fLFyiU-4"  # Reemplaza con tu clave API real

# Rutas donde guardaremos los archivos de audio temporalmente
AUDIO_PATH_MP3 = "output.mp3"
AUDIO_PATH_WAV = "output.wav"

@app.route('/get-audio', methods=['POST'])
def get_audio():
    # Obtener el texto enviado desde la solicitud
    text = request.form['text']

    # Crear la solicitud para la API de Google TTS
    url = f"https://texttospeech.googleapis.com/v1/text:synthesize?key={GOOGLE_API_KEY}"
    headers = {
        "Content-Type": "application/json"
    }
    data = {
        "input": {
            "text": text
        },
        "voice": {
            "languageCode": "en-US",
            "ssmlGender": "NEUTRAL"
        },
        "audioConfig": {
            "audioEncoding": "MP3"
        }
    }

    # Enviar la solicitud a la API de Google TTS
    response = requests.post(url, headers=headers, json=data)

    # Verificar si la respuesta fue exitosa (HTTP 200)
    if response.status_code == 200:
        # Obtener el contenido de audio en base64
        audio_content = response.json().get('audioContent', None)
        
        if audio_content:
            # Guardar el archivo MP3 temporalmente
            with open(AUDIO_PATH_MP3, "wb") as out:
                out.write(base64.b64decode(audio_content))

            # Convertir MP3 a WAV usando pydub
            sound = AudioSegment.from_mp3(AUDIO_PATH_MP3)
            # Exportar con los parámetros correctos para 44.1 kHz y estéreo
            sound.export(AUDIO_PATH_WAV, format="wav", parameters=["-ar", "44100", "-ac", "2"])

            # Enviar el archivo WAV al cliente (ESP32)
            return send_file(AUDIO_PATH_WAV, mimetype='audio/wav')
        else:
            return "Error: No se recibió contenido de audio.", 500
    else:
        return f"Error en la conversión de texto a audio: {response.text}", 500

if __name__ == '__main__':
    # Ejecutar el servidor Flask
    app.run(host='0.0.0.0', port=5000)

