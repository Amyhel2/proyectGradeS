<?php

namespace App\Controllers;

use App\Models\CriminalsModel;
use App\Models\DetectionModel;
use App\Models\UsersModel;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Reports extends BaseController
{
    public function index()
    {
        //
        return view('reports/index');
    }
    public function detalleCriminal($criminalId)
    {
        $criminalModel = new CriminalsModel();
        $detectionModel = new DetectionModel();
        $userModel = new UsersModel();

        // Obtener la información del criminal
        $data['criminal'] = $criminalModel->find($criminalId);
        
        // Obtener la información de la detección más reciente para este criminal
        $data['deteccion'] = $detectionModel->where('criminal_id', $criminalId)->orderBy('fecha_deteccion', 'DESC')->first();

        // Obtener la información del oficial que realizó la detección
        $data['oficial'] = $userModel->find($data['deteccion']['oficial_id']);
        
        return view('reports/index', $data);
    }



    public function criminalesBuscados()
    {
        $model = new CriminalsModel();
        $criminales = $model->getCriminalesBuscados(); // Aquí llamas a la función que ejecuta la consulta SQL

        // Instanciar Dompdf
        $dompdf = new Dompdf();

        // Cargar vista en HTML
        $html = view('reportes/criminales_buscados', ['criminales' => $criminales]);
        $dompdf->loadHtml($html);

        // (Opcional) Configurar tamaño de papel y orientación
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $dompdf->render();

        // Salida del PDF al navegador
        $dompdf->stream("reporte_criminales_buscados.pdf", ["Attachment" => false]);
    }
    
}
