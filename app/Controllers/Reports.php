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

    public function generarReporteDeteccionesPorPeriodo()
    {
        $detectionModel = new DetectionModel();
        $data['detecciones'] = $detectionModel->select('DATE(fecha_deteccion) as fecha_deteccion, COUNT(*) as total')
                                              ->groupBy('DATE(fecha_deteccion)')
                                              ->orderBy('fecha_deteccion', 'DESC')
                                              ->findAll();

        $this->generarPDF('reports/detecciones_por_periodo', $data, 'reporte_detecciones_por_periodo');
    }

    public function reporteCriminalesDetectados()
    {
        $detectionModel = new DetectionModel();
        $data['criminales'] = $detectionModel->select('criminal_id, COUNT(*) as total')
                                             ->join('criminals', 'criminals.idCriminal = detections.criminal_id')
                                             ->groupBy('criminal_id')
                                             ->orderBy('total', 'DESC')
                                             ->findAll();

        $this->generarPDF('reports/criminales_detectados', $data, 'reporte_criminales_detectados');
    }

    public function reporteActividadDeOficiales()
    {
        $detectionModel = new DetectionModel();
        $data['actividad'] = $detectionModel->select('users.nombres, COUNT(detections.idDeteccion) as total')
                                            ->join('users', 'users.id = detections.oficial_id')
                                            ->groupBy('users.id')
                                            ->orderBy('total', 'DESC')
                                            ->findAll();

        $this->generarPDF('reports/actividad_de_oficiales', $data, 'reporte_actividad_de_oficiales');
    }

    public function reporteCriminalesPorDelito()
    {
        $criminalsModel = new CriminalsModel();
        $data['criminales_por_delito'] = $criminalsModel->select('delitos.tipo, COUNT(criminals.idCriminal) as total')
                                                        ->join('criminal_delitos', 'criminals.idCriminal = criminal_delitos.criminal_id')
                                                        ->join('delitos', 'delitos.idDelito = criminal_delitos.delito_id')
                                                        ->groupBy('delitos.tipo')
                                                        ->findAll();

        $this->generarPDF('reports/criminales_por_delito', $data, 'reporte_criminales_por_delito');
    }

    public function reporteUbicacionesDeteccion()
    {
        $detectionModel = new DetectionModel();
        $data['ubicaciones'] = $detectionModel->select('ubicacion, COUNT(*) as total')
                                              ->groupBy('ubicacion')
                                              ->orderBy('total', 'DESC')
                                              ->findAll();

        $this->generarPDF('reports/ubicaciones_deteccion', $data, 'reporte_ubicaciones_deteccion');
    }

    public function reporteDeteccionesPorDispositivo()
    {
        $detectionModel = new DetectionModel();
        $data['detecciones_dispositivo'] = $detectionModel->select('gafas.device_id, COUNT(detections.idDeteccion) as total')
                                                          ->join('gafas', 'gafas.id = detections.oficial_id')
                                                          ->groupBy('gafas.device_id')
                                                          ->orderBy('total', 'DESC')
                                                          ->findAll();

        $this->generarPDF('reports/detecciones_por_dispositivo', $data, 'reporte_detecciones_por_dispositivo');
    }

    public function reporteCriminalesActivosInactivos()
    {
        $criminalsModel = new CriminalsModel();
        $data['criminales'] = $criminalsModel->select('activo, COUNT(*) as total')
                                             ->groupBy('activo')
                                             ->findAll();

        $this->generarPDF('reports/criminales_activos_inactivos', $data, 'reporte_criminales_activos_inactivos');
    }

    

    public function reporteCriminalesAltasConfianzas()
    {
        $detectionModel = new DetectionModel();
        $data['criminales'] = $detectionModel->select('criminal_id, AVG(confianza) as confianza_media')
                                             ->groupBy('criminal_id')
                                             ->having('confianza_media > 40')
                                             ->findAll();

        $this->generarPDF('reports/criminales_altas_confianzas', $data, 'reporte_criminales_altas_confianzas');
    }

    public function reporteAvistamientosPorUbicacion()
    {
        $detectionModel = new DetectionModel();
        $data['avistamientos'] = $detectionModel->select('ubicacion, COUNT(*) as total')
                                                ->groupBy('ubicacion')
                                                ->orderBy('total', 'DESC')
                                                ->findAll();

        $this->generarPDF('reports/avistamientos_por_ubicacion', $data, 'reporte_avistamientos_por_ubicacion');
    }
}
