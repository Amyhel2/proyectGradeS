from flask import Flask, request, jsonify
import face_recognition
import os
import requests

app = Flask(__name__)

# Ruta donde están las imágenes de los criminales
RUTA_CRIMINALES = 'C:/xampp/htdocs/proyectGradeS/public/uploads/criminales/'  # Asegúrate de que esta ruta es correcta
URL_API_DETECCIONES = 'http://localhost/proyectGradeS/public/detectar/almacenarDeteccion/'  # Cambia esto a la URL de tu API en CodeIgniter

@app.route('/upload', methods=['POST'])
def upload_file():
    if not request.data:
        return jsonify({"error": "No file part"}), 400

    # Obtener el ID del dispositivo de la cabecera correcta
    device_id = request.headers.get('Device-ID') 
    print(f"ID del dispositivo: {device_id}")

    try:
        # Guarda el archivo recibido
        with open('received_image.jpg', 'wb') as f:
            f.write(request.data)
        print("Archivo recibido y guardado.")

        # Aquí se llama a la función que compara la imagen recibida con la base de datos
        resultado = comparar_imagen_con_base('received_image.jpg')

        if resultado:
            criminal_id = resultado.split("_")[0]  # Extrae el ID del criminal
            response = requests.post(f"{URL_API_DETECCIONES}{criminal_id}/{device_id}")


            if response.status_code == 200:
                print("Detección almacenada correctamente.")
            else:
                print("Error al almacenar la detección:", response.text)

            return jsonify({
                "message": "File received and criminal detected",
                "criminal_detected": True,
                "nombre_criminal": resultado,
                "device_id": device_id  # Incluye el ID del dispositivo en la respuesta
            }), 200
        else:
            return jsonify({
                "message": "File received but no criminal detected",
                "criminal_detected": False,
                "device_id": device_id  # Incluye el ID del dispositivo en la respuesta
            }), 200

    except Exception as e:
        print("Error al procesar el archivo:", str(e))
        return jsonify({"error": "Failed to process file"}), 500


def comparar_imagen_con_base(imagen_recibida):
    """
    Compara la imagen recibida con las imágenes de criminales almacenadas.
    """
    try:
        # Cargar la imagen recibida
        imagen_capturada = face_recognition.load_image_file(imagen_recibida)
        encoding_capturada = face_recognition.face_encodings(imagen_capturada)

        if not encoding_capturada:
            print("No se detectó ningún rostro en la imagen.")
            return None

        encoding_capturada = encoding_capturada[0]

        # Comparar con cada imagen de criminal almacenada
        for archivo in os.listdir(RUTA_CRIMINALES):
            ruta_criminal = os.path.join(RUTA_CRIMINALES, archivo)
            
            # Imprimir el nombre del archivo de la imagen del criminal que se está accediendo
            print(f"Accediendo a la imagen del criminal: {archivo}")

            imagen_criminal = face_recognition.load_image_file(ruta_criminal)
            encoding_criminal = face_recognition.face_encodings(imagen_criminal)

            if not encoding_criminal:
                print(f"No se encontró encoding en la imagen: {archivo}")
                continue

            encoding_criminal = encoding_criminal[0]

            # Comparar la imagen capturada con la imagen del criminal
            coincidencia = face_recognition.compare_faces([encoding_criminal], encoding_capturada)

            if coincidencia[0]:
                nombre_criminal = archivo.split(".")[0]  # Asume que el nombre del archivo es el nombre del criminal
                print(f"¡Coincidencia encontrada con: {nombre_criminal}!")
                return nombre_criminal  # Devuelve el nombre del criminal

        print("No se encontró ningún criminal coincidente.")
        return None
    except Exception as e:
        print("Error en la comparación de imágenes:", str(e))
        return None

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000, debug=True)
