import cv2
import requests
import os

# Cargar la imagen capturada y comparar con imágenes de la base de datos
def comparar_imagenes(imagen_capturada, rutas_imagenes_crud):
    img_capturada = cv2.imread(imagen_capturada, cv2.IMREAD_GRAYSCALE)
    
    # Verificar si la imagen fue cargada correctamente
    if img_capturada is None:
        print(f"No se pudo cargar la imagen capturada: {imagen_capturada}")
        return
    
    # Cargar imágenes del CRUD y comparar
    for ruta in rutas_imagenes_crud:
        for root, dirs, files in os.walk(ruta):
            for file in files:
                # Obtener la ruta completa de la imagen en CRUD
                img_path = os.path.join(root, file)
                
                # Cargar la imagen para comparar
                img_comparar = cv2.imread(img_path, cv2.IMREAD_GRAYSCALE)
                
                # Verificar si la imagen fue cargada correctamente
                if img_comparar is None:
                    print(f"No se pudo cargar la imagen del CRUD: {img_path}")
                    continue
                
                # Comparar las dos imágenes
                res = cv2.matchTemplate(img_capturada, img_comparar, cv2.TM_CCOEFF_NORMED)
                min_val, max_val, min_loc, max_loc = cv2.minMaxLoc(res)

                # Verificar si la similitud supera el umbral
                if max_val > 0.8:  # Umbral de similitud
                    print(f"Coincidencia encontrada con {img_path} (Similitud: {max_val:.2f})")
                    return  # Terminar la búsqueda si se encuentra una coincidencia

    print("No se encontró ninguna coincidencia.")

# Llamar a la función comparar_imagenes
comparar_imagenes('/upload/imagen_capturada.jpg', ['/ruta/a/imagenes/criminales', '/ruta/a/otra_carpeta'])
