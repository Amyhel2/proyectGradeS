from flask import Flask, request, jsonify
import face_recognition
import os
import numpy as np
import requests
import shutil

app = Flask(__name__)

# Rutas del sistema
RUTA_CRIMINALES = 'C:/xampp/htdocs/proyectGradeS/public/uploads/criminales/'
RUTA_IMAGENES_DETECTADOS = 'C:/xampp/htdocs/proyectGradeS/public/uploads/ImagenesCriminalesDetectados/'
URL_API_DETECCIONES = 'http://localhost/proyectGradeS/public/detectar/almacenarDeteccion/'

@app.route('/upload', methods=['POST'])
def upload_file():
    if not request.data:
        return jsonify({"error": "No hay parte del archivo"}), 400

    device_id = request.headers.get('Device-ID')
    latitud = request.headers.get('Latitud')
    longitud = request.headers.get('Longitud')

    print(f"ID del dispositivo: {device_id}")
    print(f"Latitud: {latitud}, Longitud: {longitud}")

    try:
        # Guarda el archivo recibido
        with open('received_image.jpg', 'wb') as f:
            f.write(request.data)
        print("Archivo recibido y guardado.")

        # Compara la imagen con la base de datos de criminales
        resultado, confianza = comparar_imagen_con_base('received_image.jpg')

        if resultado:  # Si se encontró una coincidencia
            # Extraer el ID y nombre del criminal del nombre del archivo
            partes_nombre = resultado.split("_")
            criminal_id = partes_nombre[-1]
            nombre_criminal = "_".join(partes_nombre[:-1])  # Asumiendo que el nombre está antes del ID

            # Obtener la extensión del archivo
            extension = 'jpg'  # Cambia esto según el formato de tus imágenes

            # Crear el nombre del archivo detectado en el formato idCriminal_nombrecriminal.extensión
            nombre_imagen_detectada = f"{nombre_criminal}.{extension}"
            ruta_imagen_destino = os.path.join(RUTA_IMAGENES_DETECTADOS, nombre_imagen_detectada)

            # Mover la imagen recibida a la carpeta de imágenes detectadas
            shutil.move('received_image.jpg', ruta_imagen_destino)

            # Enviar solicitud para almacenar la detección en la base de datos
            respuesta = requests.post(
                f"{URL_API_DETECCIONES}{criminal_id}/{device_id}",
                data={
                    "confianza": confianza,
                    "latitud": latitud,
                    "longitud": longitud,
                    "foto_deteccion": nombre_imagen_detectada
                }
            )

            if respuesta.status_code == 200:
                print("Detección almacenada correctamente.")
            else:
                print("Error al almacenar la detección:", respuesta.text)

            return jsonify({
                "message": "Archivo recibido y criminal detectado",
                "criminal_detected": True,
                "nombre_criminal": resultado,
                "confianza": confianza,
                "device_id": device_id,
                "latitud": latitud,
                "longitud": longitud
            }), 200
        else:
            return jsonify({
                "message": "Archivo recibido pero no se detectó ningún delincuente",
                "criminal_detected": False,
                "device_id": device_id,
                "latitud": latitud,
                "longitud": longitud
            }), 200

    except Exception as e:
        print("Error al procesar el archivo:", str(e))
        return jsonify({"error": "Failed to process file"}), 500

def comparar_imagen_con_base(imagen_recibida):
    try:
        imagen_capturada = face_recognition.load_image_file(imagen_recibida)
        encoding_capturada = face_recognition.face_encodings(imagen_capturada)

        if not encoding_capturada:
            print("No se detectó ningún rostro en la imagen.")
            return None, None

        encoding_capturada = encoding_capturada[0]
        mejor_coincidencia = None
        mayor_confianza = None

        for archivo in os.listdir(RUTA_CRIMINALES):
            ruta_criminal = os.path.join(RUTA_CRIMINALES, archivo)
            print(f"Accediendo a la imagen del criminal: {archivo}")

            imagen_criminal = face_recognition.load_image_file(ruta_criminal)
            encoding_criminal = face_recognition.face_encodings(imagen_criminal)

            if not encoding_criminal:
                print(f"No se encontró codificación en la imagen: {archivo}")
                continue

            encoding_criminal = encoding_criminal[0]
            coincidencia = face_recognition.compare_faces([encoding_criminal], encoding_capturada)
            distancia = face_recognition.face_distance([encoding_criminal], encoding_capturada)
            confianza = (1 - distancia[0]) * 100

            if coincidencia[0]:
                nombre_criminal = archivo.split(".")[0]
                if mejor_coincidencia is None or confianza > mayor_confianza:
                    mejor_coincidencia = nombre_criminal
                    mayor_confianza = confianza

        if mejor_coincidencia:
            print(f"¡Coincidencia encontrada con: {mejor_coincidencia}! Confianza: {mayor_confianza}%")
            return mejor_coincidencia, round(mayor_confianza, 2)
        else:
            print("No se encontró ningún criminal coincidente.")
            return None, None

    except Exception as e:
        print("Error en la comparación de imágenes:", str(e))
        return None, None

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000, debug=True)
