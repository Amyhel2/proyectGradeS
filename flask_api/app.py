from flask import Flask, request, jsonify
import face_recognition
import os
import time  # Asegúrate de importar 'time' para generar un timestamp
import requests

app = Flask(__name__)

# Ruta donde están las imágenes de los criminales
RUTA_CRIMINALES = 'C:/xampp/htdocs/proyectGradeS/public/uploads/criminales/'
# Ruta donde se guardarán las imágenes detectadas
RUTA_DETECCIONES = 'C:/xampp/htdocs/proyectGradeS/public/uploads/ImagenesCriminalesDetectados/'
URL_API_DETECCIONES = 'http://localhost/proyectGradeS/public/detectar/almacenarDeteccion/'

# Asegúrate de que la carpeta de detecciones existe
if not os.path.exists(RUTA_DETECCIONES):
    os.makedirs(RUTA_DETECCIONES)

@app.route('/upload', methods=['POST'])
def upload_file():
    if not request.data:
        return jsonify({"error": "No file part"}), 400

    # Obtener el ID del dispositivo y las coordenadas GPS desde los headers
    device_id = request.headers.get('Device-ID')
    latitud = request.headers.get('Latitud')
    longitud = request.headers.get('Longitud')

    print(f"ID del dispositivo: {device_id}")
    print(f"Latitud: {latitud}, Longitud: {longitud}")

    try:
        # Guardar la imagen recibida en la carpeta de detecciones
        nombre_imagen = f"detected_image_{device_id}_{int(time.time())}.jpg"
        ruta_imagen = os.path.join(RUTA_DETECCIONES, nombre_imagen)

        with open(ruta_imagen, 'wb') as f:
            f.write(request.data)
        print(f"Imagen detectada y guardada en: {ruta_imagen}")

        # Compara la imagen recibida con la base de datos de criminales
        resultado, confianza = comparar_imagen_con_base(ruta_imagen)

        if resultado:
            criminal_id = resultado.split("_")[-1].split(".")[0]  # Extraer el ID del criminal
            response = requests.post(
                f"{URL_API_DETECCIONES}{criminal_id}/{device_id}",
                data={
                    "confianza": confianza,
                    "latitud": latitud,       # Añadir la latitud
                    "longitud": longitud,     # Añadir la longitud
                    "imagen_detectada": nombre_imagen  # Enviar el nombre de la imagen detectada
                }
            )

            if response.status_code == 200:
                print("Detección almacenada correctamente.")
            else:
                print("Error al almacenar la detección:", response.text)

            return jsonify({
                "message": "File received and criminal detected",
                "criminal_detected": True,
                "nombre_criminal": resultado,
                "confianza": confianza,
                "device_id": device_id,
                "latitud": latitud,
                "longitud": longitud,
                "imagen_detectada": nombre_imagen  # Incluir la imagen detectada en la respuesta
            }), 200
        else:
            return jsonify({
                "message": "File received but no criminal detected",
                "criminal_detected": False,
                "device_id": device_id,
                "latitud": latitud,
                "longitud": longitud
            }), 200

    except Exception as e:
        print("Error al procesar el archivo:", str(e))
        return jsonify({"error": "Failed to process file"}), 500


def comparar_imagen_con_base(imagen_recibida):
    """
    Compara la imagen recibida con las imágenes de criminales almacenadas y calcula la confianza.
    """
    try:
        # Cargar la imagen recibida
        imagen_capturada = face_recognition.load_image_file(imagen_recibida)
        encoding_capturada = face_recognition.face_encodings(imagen_capturada)

        if not encoding_capturada:
            print("No se detectó ningún rostro en la imagen.")
            return None, None

        encoding_capturada = encoding_capturada[0]

        # Inicializar la variable para el mejor resultado
        mejor_coincidencia = None
        mayor_confianza = None

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

            # Calcular la distancia y la confianza
            coincidencia = face_recognition.compare_faces([encoding_criminal], encoding_capturada)
            distancia = face_recognition.face_distance([encoding_criminal], encoding_capturada)

            # Convertir la distancia en un porcentaje de confianza
            confianza = (1 - distancia[0]) * 100

            if coincidencia[0]:
                nombre_criminal = archivo.split(".")[0]  # Asume que el nombre del archivo es el nombre del criminal

                # Si esta coincidencia es mejor (confianza más alta), guardarla
                if mejor_coincidencia is None or confianza > mayor_confianza:
                    mejor_coincidencia = nombre_criminal
                    mayor_confianza = confianza

        if mejor_coincidencia:
            print(f"¡Coincidencia encontrada con: {mejor_coincidencia}! Confianza: {mayor_confianza}%")
            return mejor_coincidencia, round(mayor_confianza, 2)  # Devolver el nombre del criminal y el porcentaje de confianza
        else:
            print("No se encontró ningún criminal coincidente.")
            return None, None

    except Exception as e:
        print("Error en la comparación de imágenes:", str(e))
        return None, None


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000, debug=True)
