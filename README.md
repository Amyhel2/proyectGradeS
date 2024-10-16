# **Sistema de Reconocimiento Facial para Seguridad Pública**

Este proyecto implementa un **Sistema de Reconocimiento Facial en Tiempo Real** diseñado para apoyar a las fuerzas de seguridad pública en la identificación automática de criminales. Utilizando una combinación de tecnologías como **ESP32-CAM**, **Python**, y **CodeIgniter 4**, el sistema facilita la captura, procesamiento y comparación de imágenes, enviando notificaciones en tiempo real cuando se detectan coincidencias.

## **Tabla de Contenidos**
1. [Descripción General](#descripción-general)
2. [Características Principales](#características-principales)
3. [Componentes Electrónicos](#componentes-electrónicos)
4. [Requisitos del Sistema](#requisitos-del-sistema)
5. [Instalación](#instalación)
6. [Uso](#uso)
7. [Estructura del Proyecto](#estructura-del-proyecto)
8. [Contribuciones](#contribuciones)
9. [Licencia](#licencia)

## **Descripción General**

Este sistema de reconocimiento facial está diseñado para mejorar las operaciones de las fuerzas de seguridad pública mediante el uso de tecnologías avanzadas de procesamiento de imágenes. Permite la detección de rostros en tiempo real a través de cámaras incorporadas en gafas inteligentes (**ESP32-CAM**) y envía notificaciones automáticas a los oficiales cuando se identifica un criminal.

El sistema incluye una plataforma web para la gestión de criminales, delitos y oficiales, y permite la generación de reportes detallados sobre la actividad delictiva detectada.

## **Características Principales**

- **Detección Facial en Tiempo Real**: Utiliza cámaras **ESP32-CAM** para capturar imágenes de rostros en tiempo real y comparar esas imágenes con una base de datos de criminales.
- **Gestión de Criminales y Delitos**: Administra información de criminales, asociando múltiples delitos a cada individuo.
- **Notificaciones Automáticas**: Al detectar una coincidencia, el sistema notifica automáticamente al oficial asociado, permitiendo una respuesta rápida.
- **Reportes Avanzados**: Genera informes sobre las ubicaciones más frecuentes de detección, las actividades delictivas detectadas por período, y el rendimiento de los oficiales.
- **Sistema de Autenticación**: Implementa un control de acceso basado en roles (RBAC) para administrar diferentes niveles de acceso para los usuarios (administradores y oficiales).

## **Componentes Electrónicos**

- **ESP32-CAM**: Dispositivo integrado con una cámara para la captura de imágenes en tiempo real.
- **Sensores Adicionales**: Opcionalmente, el sistema puede integrarse con sensores GPS para proporcionar información de ubicación precisa en cada detección.
- **Servidor Flask en Python**: Procesa las imágenes capturadas por el **ESP32-CAM** para realizar la comparación de rostros con la base de datos de criminales.

Estos componentes electrónicos son esenciales para la operación del sistema, facilitando la captura y transmisión de imágenes para su procesamiento en la plataforma web.

## **Requisitos del Sistema**

Para garantizar el correcto funcionamiento del proyecto, asegúrate de que tu entorno cumpla con los siguientes requisitos:

### **Software**
- **PHP 7.4+** (para el backend en **CodeIgniter 4**)
- **MySQL** (para la base de datos)
- **Composer** (gestor de dependencias de PHP)
- **Python 3.9** (para el procesamiento de imágenes con **Flask**)
- **Docker** (opcional, para contenerización)

### **Hardware**
- **ESP32-CAM**: Dispositivo para la captura de imágenes.
- **Servidor Local**: Servidor para alojar la aplicación web y procesar solicitudes en tiempo real.

## **Instalación**

Para instalar y configurar el proyecto en tu entorno local, sigue estos pasos:

1. **Clonar el Repositorio**
    ```bash
    git clone https://github.com/usuario/tu-proyecto.git
    ```
2. **Navegar al Directorio del Proyecto**
    ```bash
    cd tu-proyecto
    ```
3. **Instalar las Dependencias PHP**
    ```bash
    composer install
    ```
4. **Configurar el Archivo `.env`**
    - Edita el archivo `.env` para añadir las configuraciones de base de datos, rutas y otras variables de entorno necesarias.

5. **Ejecutar Migraciones de Base de Datos**
    ```bash
    php spark migrate
    ```

6. **Iniciar el Servidor Local**
    ```bash
    php spark serve
    ```

7. **Configurar el Servidor Flask**
    - Navega a la carpeta del servidor Flask para reconocimiento facial y ejecuta los siguientes comandos:
    ```bash
    python app.py
    ```

## **Uso**

### **Acceso al Panel de Control**
- Accede al panel administrativo a través de la URL `http://localhost:8080/admin`. 
- Desde el panel, podrás gestionar criminales, delitos, oficiales, y generar reportes.

### **Conectar Dispositivos ESP32-CAM**
- Conecta las cámaras **ESP32-CAM** que capturarán imágenes en tiempo real y las enviarán para su procesamiento.
- Las imágenes capturadas se compararán automáticamente con la base de datos de criminales.

### **Generación de Reportes**
- Los reportes se pueden generar desde el panel administrativo. Estos reportes incluyen información detallada sobre las detecciones realizadas, ubicaciones más frecuentes, y el rendimiento de los oficiales.

## **Estructura del Proyecto**

El proyecto sigue una estructura organizada para mantener la separación de responsabilidades:

- **/app/Controllers**: Lógica de negocio y manejo de solicitudes HTTP.
- **/app/Models**: Modelos que interactúan con las tablas de la base de datos.
- **/app/Views**: Plantillas HTML para las vistas del sistema.
- **/public/uploads**: Almacena las imágenes subidas, incluidas las imágenes de criminales y las detecciones realizadas.
- **/python_scripts**: Scripts de Python utilizados para el reconocimiento facial y otras tareas de procesamiento de imágenes.

## **Contribuciones**

Las contribuciones son bienvenidas. Si deseas mejorar el proyecto, sigue estos pasos:

1. **Haz un fork** del repositorio.
2. **Crea una nueva rama** para tu funcionalidad (`git checkout -b feature/nueva-funcionalidad`).
3. Realiza los cambios necesarios y **haz commit** (`git commit -am 'Añadir nueva funcionalidad'`).
4. **Envía tus cambios** a tu repositorio (`git push origin feature/nueva-funcionalidad`).
5. Abre un **pull request** para que tus cambios sean revisados.

## **Licencia**

.
