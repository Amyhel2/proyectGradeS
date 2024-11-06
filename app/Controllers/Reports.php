<?php

namespace App\Controllers;

use App\Models\CriminalsModel;
use App\Models\DetectionModel;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;

class Reports extends BaseController
{
    public function index()
    {
        return view('reports/index');
    }

    // Método reutilizable para generar PDFs
    private function generarPDF($view, $data, $nombreArchivo)
    {
        // Renderizar la vista a HTML
        $html = view($view, $data);

        // Configuración de Dompdf
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Tamaño del papel y orientación
        $dompdf->render();

        // Descargar el archivo PDF
        $dompdf->stream($nombreArchivo . '.pdf', ['Attachment' => true]);
    }

    // 1. Reporte de coincidencias de reconocimiento facial por zona
    public function generarReporteDeteccionesPorZona()
    {
        $detectionModel = new DetectionModel();
        $data['detecciones_zona'] = $detectionModel->select('ubicacion, COUNT(*) as total, MAX(fecha_deteccion) as ultima_deteccion')
                                                   ->groupBy('ubicacion')
                                                   ->orderBy('total', 'DESC')
                                                   ->findAll();

        $this->generarPDF('reports/detecciones_por_zona', $data, 'reporte_detecciones_por_zona');
    }

    // 2. Reporte de alertas generadas por identificación positiva de sospechosos
    public function reporteAlertasGeneradas()
    {
        $detectionModel = new DetectionModel();
        $data['alertas'] = $detectionModel->select('criminals.nombre, detections.fecha_deteccion, detections.ubicacion, detections.confianza')
                                          ->join('criminals', 'criminals.idCriminal = detections.criminal_id')
                                          ->where('detections.confianza >= 40') // Umbral de confianza para considerar una alerta positiva
                                          ->orderBy('detections.fecha_deteccion', 'DESC')
                                          ->findAll();

        $this->generarPDF('reports/alertas_generadas', $data, 'reporte_alertas_generadas');
    }

    // 3. Reporte de criminales buscados actualizados
    public function reporteCriminalesActualizados()
    {
        $criminalsModel = new CriminalsModel();
        $data['criminales_actualizados'] = $criminalsModel->select('idCriminal, nombre, alias, delitos, razon_busqueda, activo, actualizado_en')
                                                          ->orderBy('actualizado_en', 'DESC')
                                                          ->findAll();

        $this->generarPDF('reports/criminales_actualizados', $data, 'reporte_criminales_actualizados');
    }

    // 4. Reporte de rendimiento del sistema (precisión de reconocimiento)
    public function reporteRendimientoSistema()
    {
        $detectionModel = new DetectionModel();
        $data['rendimiento'] = $detectionModel->select('COUNT(*) as total_detecciones, AVG(confianza) as promedio_confianza')
                                              ->findAll();
    
        // Asumimos que solo habrá un resultado en este caso
        $data['total_detecciones'] = $data['rendimiento'][0]['total_detecciones'];
        $data['promedio_confianza'] = $data['rendimiento'][0]['promedio_confianza'];
    
        $this->generarPDF('reports/rendimiento_sistema', $data, 'reporte_rendimiento_sistema');
    }
    

    // 5. Reporte de incidentes de falsas alarmas
    public function reporteFalsasAlarmas()
    {
        $detectionModel = new DetectionModel();
        $data['falsas_alarmas'] = $detectionModel->select('idDeteccion, ubicacion, fecha_deteccion, confianza')
                                                 ->where('confianza < 50') // Considerar detecciones con baja confianza como falsas alarmas
                                                 ->orderBy('fecha_deteccion', 'DESC')
                                                 ->findAll();

        $this->generarPDF('reports/falsas_alarmas', $data, 'reporte_falsas_alarmas');
    }

    // 6. Reporte de actividades de verificación manual
    public function reporteActividadesVerificacionManual()
    {
        $detectionModel = new DetectionModel();
        $data['verificaciones'] = $detectionModel->select('users.nombres, detections.fecha_deteccion, detections.ubicacion, detections.confianza')
                                                 ->join('users', 'users.id = detections.oficial_id')
                                                 ->where('detections.verificacion_manual', 1) // Campo adicional para identificar verificaciones manuales
                                                 ->orderBy('detections.fecha_deteccion', 'DESC')
                                                 ->findAll();

        $this->generarPDF('reports/verificacion_manual', $data, 'reporte_verificacion_manual');
    }
}
