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

    public function generarReporteDeteccionesPorPeriodo()
{
    $detectionModel = new DetectionModel();
    $data['detecciones'] = $detectionModel->select('DATE(fecha_deteccion) as fecha_deteccion, COUNT(*) as total')
                                        ->groupBy('DATE(fecha_deteccion)')
                                        ->orderBy('fecha_deteccion', 'DESC')
                                        ->findAll();


    // Cargar la vista con los datos para el PDF
    $html = view('reports/pdf/detecciones_por_periodo', $data);

    // Instanciar Dompdf
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape'); // Cambia a 'portrait' si prefieres vertical
    $dompdf->render();
    $dompdf->stream('reporte_detecciones_por_periodo.pdf', ['Attachment' => true]); // Para forzar la descarga
}


    public function reporteCriminalesDetectados()
    {
        // Lógica para obtener criminales detectados
        $detectionModel = new DetectionModel();
        $data['criminales'] = $detectionModel->select('criminal_id, COUNT(*) as total')
                                               ->groupBy('criminal_id')
                                               ->orderBy('total', 'DESC')
                                               ->findAll();
        
        return view('reports/criminales_detectados', $data);
    }

    public function reporteActividadDeOficiales()
    {
        // Lógica para obtener la actividad de los oficiales
        $detectionModel = new DetectionModel();
        $data['actividad'] = $detectionModel->select('oficial_id, COUNT(*) as total')
                                             ->groupBy('oficial_id')
                                             ->orderBy('total', 'DESC')
                                             ->findAll();

        return view('reports/actividad_de_oficiales', $data);
    }

    public function reporteCriminalesPorDelito()
    {
        // Lógica para obtener criminales por delito
        $criminalsModel = new CriminalsModel();
        $data['criminales_por_delito'] = $criminalsModel->select('delitos, COUNT(*) as total')
                                                          ->groupBy('delitos')
                                                          ->findAll();
        
        return view('reports/criminales_por_delito', $data);
    }

    public function reporteUbicacionesDeteccion()
    {
        // Lógica para obtener ubicaciones de detección
        $detectionModel = new DetectionModel();
        $data['ubicaciones'] = $detectionModel->select('ubicacion, COUNT(*) as total')
                                                ->groupBy('ubicacion')
                                                ->orderBy('total', 'DESC')
                                                ->findAll();

        return view('reports/ubicaciones_deteccion', $data);
    }

    public function reporteDeteccionesPorDispositivo()
    {
        // Lógica para obtener detecciones por dispositivo
        $detectionModel = new DetectionModel();
        $data['deteciones_dispositivo'] = $detectionModel->select('device_id, COUNT(*) as total')
                                                          ->groupBy('device_id')
                                                          ->orderBy('total', 'DESC')
                                                          ->findAll();

        return view('reports/detecciones_por_dispositivo', $data);
    }

    public function reporteCriminalesActivosInactivos()
    {
        // Lógica para obtener criminales activos e inactivos
        $criminalsModel = new CriminalsModel();
        $data['criminales'] = $criminalsModel->findAll();

        return view('reports/criminales_activos_inactivos', $data);
    }

    public function reporteReincidencias()
    {
        // Lógica para obtener reincidencias
        $criminalsModel = new CriminalsModel();
        $data['reincidencias'] = $criminalsModel->where('reincidente', 1)->findAll();

        return view('reports/reincidencias', $data);
    }

    public function reporteCriminalesAltasConfianzas()
    {
        // Lógica para obtener criminales con altas confianzas
        $detectionModel = new DetectionModel();
        $data['criminales'] = $detectionModel->select('criminal_id, AVG(confianza) as confianza_media')
                                               ->groupBy('criminal_id')
                                               ->having('confianza_media > 40') // Por ejemplo, mayor al 80%
                                               ->findAll();

        return view('reports/criminales_altas_confianzas', $data);
    }

    public function reporteAvistamientosPorUbicacion()
    {
        // Lógica para obtener avistamientos de criminales por ubicación
        $detectionModel = new DetectionModel();
        $data['avistamientos'] = $detectionModel->select('ubicacion, COUNT(*) as total')
                                                 ->groupBy('ubicacion')
                                                 ->orderBy('total', 'DESC')
                                                 ->findAll();

        return view('reports/avistamientos_por_ubicacion', $data);
    }
}

