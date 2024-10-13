from flask import Flask, request, jsonify
import face_recognition
import os
import numpy as np
import requests

app = Flask(__name__)

# Ruta donde están las imágenes de los criminales
RUTA_CRIMINALES = 'C:/xampp/htdocs/proyectGradeS/public/uploads/criminales/'  # Asegúrate de que esta ruta es correcta
URL_API_DETECCIONES = 'http://localhost/proyectGradeS/public/detectar/almacenarDeteccion/'  # Cambia esto a la URL de tu API en CodeIgniter

@app.route('/upload', methods=['POST'])
def upload_file():
    # Verifica si se recibió algún archivo en la solicitud
    if not request.data:
        return jsonify({"error": "No hay parte del archivo"}), 400

    # Obtener el ID del dispositivo y las coordenadas GPS desde los encabezados
    device_id = request.headers.get('Device-ID')
    latitud = request.headers.get('Latitud')
    longitud = request.headers.get('Longitud')

    # Imprimir los valores recibidos para depuración
    print(f"ID del dispositivo: {device_id}")
    print(f"Latitud: {latitud}, Longitud: {longitud}")

    try:
        # Guarda el archivo recibido en el servidor con el nombre 'received_image.jpg'
        with open('received_image.jpg', 'wb') as f:
            f.write(request.data)
        print("Archivo recibido y guardado.")

        # Compara la imagen recibida con la base de datos de criminales
        resultado, confianza = comparar_imagen_con_base('received_image.jpg')

        if resultado:  # Si se encontró una coincidencia
            # Extrae el ID del criminal del nombre del archivo (suponiendo que está antes del primer "_")
            criminal_id = resultado.split("_")[-1]

            # Envía una solicitud POST a la API para almacenar la detección
            respuesta = requests.post(
                f"{URL_API_DETECCIONES}{criminal_id}/{device_id}",
                    data={
                    "confianza": confianza,
                    "latitud": latitud,  # Añadir la latitud
                    "longitud": longitud  # Añadir la longitud
                }
            )

            # Verifica si la solicitud fue exitosa
            if respuesta.status_code == 200:
                print("Detección almacenada correctamente.")
            else:
                print("Error al almacenar la detección:", respuesta.text)

            # Devuelve una respuesta indicando que se detectó un criminal
            return jsonify({
                "message": "Archivo recibido y criminal detectado",
                "criminal_detected": True,
                "nombre_criminal": resultado,
                "confianza": confianza,
                "device_id": device_id,
                "latitud": latitud,  # Incluir la latitud en la respuesta
                "longitud": longitud  # Incluir la longitud en la respuesta
            }), 200
        else:
            # Si no se encontró ninguna coincidencia, devuelve una respuesta indicando que no se detectó ningún criminal
            return jsonify({
                "message": "Archivo recibido pero no se detectó ningún delincuente",
                "criminal_detected": False,
                "device_id": device_id,
                "latitud": latitud,  # Incluir la latitud en la respuesta
                "longitud": longitud  # Incluir la longitud en la respuesta
            }), 200

    except Exception as e:
        # Si ocurre algún error, imprime el mensaje de error y devuelve una respuesta de fallo
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

        # Verifica si se detectó algún rostro en la imagen
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

            # Cargar la imagen del criminal y obtener su codificación facial
            imagen_criminal = face_recognition.load_image_file(ruta_criminal)
            encoding_criminal = face_recognition.face_encodings(imagen_criminal)

            # Si no se encontró un encoding en la imagen, saltar esta iteración
            if not encoding_criminal:
                print(f"No se encontró codificación en la imagen: {archivo}")
                continue

            encoding_criminal = encoding_criminal[0]

            # Calcular la coincidencia y la distancia entre los encodings faciales
            coincidencia = face_recognition.compare_faces([encoding_criminal], encoding_capturada)
            distancia = face_recognition.face_distance([encoding_criminal], encoding_capturada)

            # Convertir la distancia en un porcentaje de confianza
            confianza = (1 - distancia[0]) * 100

            if coincidencia[0]:  # Si hay coincidencia, verificar si la confianza es la mejor encontrada hasta ahora
                nombre_criminal = archivo.split(".")[0]  # Asume que el nombre del archivo es el nombre del criminal

                # Si esta coincidencia es mejor (confianza más alta), guardarla
                if mejor_coincidencia is None or confianza > mayor_confianza:
                    mejor_coincidencia = nombre_criminal
                    mayor_confianza = confianza

        # Devuelve el nombre del criminal y el porcentaje de confianza si se encontró alguna coincidencia
        if mejor_coincidencia:
            print(f"¡Coincidencia encontrada con: {mejor_coincidencia}! Confianza: {mayor_confianza}%")
            return mejor_coincidencia, round(mayor_confianza, 2)
        else:
            # Si no se encontró ninguna coincidencia, notificarlo
            print("No se encontró ningún criminal coincidente.")
            return None, None

    except Exception as e:
        # En caso de error, imprimir el mensaje y devolver None
        print("Error en la comparación de imágenes:", str(e))
        return None, None

if __name__ == "__main__":
    # Ejecuta la aplicación Flask en el puerto 5000
    app.run(host='0.0.0.0', port=5000, debug=True)
