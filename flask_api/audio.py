from flask import Flask, send_file

app = Flask(__name__)

@app.route('/audio', methods=['GET'])
def send_audio():
    # Asegúrate de especificar la ruta correcta del archivo WAV en tu servidor
    audio_file_path = 'C:/xampp/htdocs/proyectGradeS/public/uploads/wav/musica.wav'
    return send_file(audio_file_path, mimetype='audio/wav')

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
