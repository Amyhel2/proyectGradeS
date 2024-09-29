<?php

namespace App\Controllers;

use App\Models\CriminalsModel;
use App\Models\UsersModel;
use App\Models\DetectionModel;
use App\Models\NotificationModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Inicializar modelos
        $criminalModel = new CriminalsModel();
        $detectionModel = new DetectionModel();
        $notificationModel = new NotificationModel();
        $userModel = new UsersModel();

        // Obtener el ID del usuario (oficial) desde la sesión
        

        // Contar los registros en las tablas principales
        $data['totalCriminales'] = $criminalModel->countAllResults();
        $data['totalDetecciones'] = $detectionModel->countAllResults();
        $data['totalNotificaciones'] = $notificationModel->countAllResults();
        $data['totalOficiales'] = $userModel->countAllResults();

        // Obtener las detecciones por mes
        $data['deteccionesPorMes'] = $detectionModel->getDeteccionesPorMes(); // Implementar en el modelo DetectionModel

        // Obtener la cantidad de criminales por tipo
        $data['criminalesPorTipo'] = $criminalModel->getCriminalesPorTipo(); // Implementar en el modelo CriminalsModel

        // Obtener las notificaciones enviadas y leídas
        $data['notificacionesEnviadasLeidas'] = $notificationModel->getNotificacionesEnviadasLeidas(); // Implementar en el modelo NotificationModel

        // Obtener el resumen de actividades recientes (últimas detecciones)
        $data['actividadesRecientes'] = $detectionModel->getActividadesRecientes(); // Implementar en el modelo DetectionModel

        // Cargar la vista con los datos
        return view('index', $data);
    }

    // Método para registrar un usuario
    public function registro()
    {
        return view('users/register');
    }

    // Método para ver el detalle de la notificación y marcarla como leída
    public function detalleNotificacion($notificacionId)
    {
        $notificationModel = new NotificationModel();

        // Marcar la notificación como leída
        $notificationModel->marcarComoLeida($notificacionId);

        // Redirigir al reporte detallado del criminal detectado
        // Se debe pasar el ID del criminal correspondiente a la notificación
        return redirect()->to(base_url('reports/detalleCriminal/' . $notificacionId));
    }

    public function header()
{
    $notificationModel = new NotificationModel();

    // Obtener el ID del usuario (oficial) desde la sesión
    $oficialId = session()->get('userid');  // Asegúrate de que el campo en la sesión es correcto

    // Verifica si el usuario está autenticado antes de intentar obtener notificaciones
    if (!$oficialId) {
        // Si no hay usuario en la sesión, puedes redirigir o manejar de otra manera
        return redirect()->to('reportes'); // O la ruta que consideres adecuada
    }

    // Obtener el número de notificaciones no leídas
    $data['cantidadNotificacionesNoLeidas'] = $notificationModel->contarNotificacionesNoLeidas($oficialId);

    // Obtener las notificaciones para mostrarlas en el dropdown
    $data['notificaciones'] = $notificationModel->where('oficial_id', $oficialId)
                                                 ->orderBy('fecha_envio', 'DESC')
                                                 ->findAll();

    // Retornar los datos a la vista o el lugar donde serán utilizados
    return view('dashboard/header', $data); // Asegúrate de tener la vista creada
}

    
}
