from flask import Flask, request, jsonify
import face_recognition
import os

app = Flask(__name__)

# Ruta donde están las imágenes de los criminales
RUTA_CRIMINALES = 'C:/xampp/htdocs/proyectGradeS/public/uploads/criminales/'


@app.route('/upload', methods=['POST'])
def upload_file():
    if not request.data:
        return jsonify({"error": "No file part"}), 400

    try:
        # Guarda el archivo recibido
        with open('received_image.jpg', 'wb') as f:
            f.write(request.data)
        print("Archivo recibido y guardado.")

        # Aquí se llama a la función que compara la imagen recibida con la base de datos
        resultado = comparar_imagen_con_base('received_image.jpg')

        if resultado:
            return jsonify({
                "message": "File received and criminal detected",
                "criminal_detected": True,
                "nombre_criminal": resultado
            }), 200
        else:
            return jsonify({
                "message": "File received but no criminal detected",
                "criminal_detected": False
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
            imagen_criminal = face_recognition.load_image_file(ruta_criminal)
            encoding_criminal = face_recognition.face_encodings(imagen_criminal)

            if not encoding_criminal:
                continue

            encoding_criminal = encoding_criminal[0]

            # Comparar la imagen capturada con la imagen del criminal
            coincidencia = face_recognition.compare_faces([encoding_criminal], encoding_capturada)

            if coincidencia[0]:
                nombre_criminal = archivo.split(".")[0]  # Asume que el nombre del archivo es el nombre del criminal
                return nombre_criminal

        return None
    except Exception as e:
        print("Error en la comparación de imágenes:", str(e))
        return None

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000, debug=True)
