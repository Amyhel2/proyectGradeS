import cv2
import face_recognition
import os
import numpy as np

# Directorio donde están almacenadas las imágenes de criminales
criminals_dir = 'uploads/criminales'

def cargar_imagenes_criminales():
    criminal_encodings = []
    criminal_names = []

    # Cargar las imágenes de criminales
    for file_name in os.listdir(criminals_dir):
        image_path = os.path.join(criminals_dir, file_name)
        image = face_recognition.load_image_file(image_path)

        # Obtener los 'encodings' faciales de la imagen
        encoding = face_recognition.face_encodings(image)

        if len(encoding) > 0:
            criminal_encodings.append(encoding[0])
            criminal_names.append(os.path.splitext(file_name)[0])  # Usar el nombre sin la extensión

    return criminal_encodings, criminal_names

def comparar_imagen(imagen_capturada_path, tolerancia=0.6):
    # Cargar la imagen capturada
    imagen_capturada = face_recognition.load_image_file(imagen_capturada_path)
    encoding_capturado = face_recognition.face_encodings(imagen_capturada)

    if len(encoding_capturado) == 0:
        print("No se encontró un rostro en la imagen capturada.")
        return None

    encoding_capturado = encoding_capturado[0]

    # Cargar los encodings de criminales
    criminal_encodings, criminal_names = cargar_imagenes_criminales()

    # Comparar la imagen capturada con cada criminal (incluyendo tolerancia)
    resultados = face_recognition.compare_faces(criminal_encodings, encoding_capturado, tolerancia)

    # Obtener las distancias de similitud para mayor precisión
    distancias = face_recognition.face_distance(criminal_encodings, encoding_capturado)

    # Si se encuentra una coincidencia
    if True in resultados:
        # Obtener el índice de la coincidencia con la menor distancia
        mejor_match_index = np.argmin(distancias)
        print(f"¡Criminal identificado: {criminal_names[mejor_match_index]}!")
        return criminal_names[mejor_match_index]  # Retorna el nombre del archivo o ID del criminal
    else:
        print("No se encontró coincidencia.")
        return None

# Ejemplo de uso:
imagen_capturada_path = 'uploads/recibidas/received_image.jpg'
criminal_identificado = comparar_imagen(imagen_capturada_path)

if criminal_identificado:
    print(f"¡Alerta! El criminal {criminal_identificado} ha sido identificado.")
else:
    print("No se ha identificado ningún criminal.")
