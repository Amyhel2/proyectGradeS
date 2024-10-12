<?php

namespace App\Controllers;

use CodeIgniter\Files\File;
use App\Controllers\BaseController;
use App\Models\CriminalsModel;
use App\Models\FotosModel;  
use App\Models\DelitosModel;

class Criminals extends BaseController
{
    public function index()
    {
        $criminalModel = new CriminalsModel();

        // Obtener criminales activos e inactivos
        $data['criminales'] = $criminalModel->where('activo', 1)->findAll();
        $data['criminalesDeshabilitados'] = $criminalModel->where('activo', 0)->findAll();

        return view('criminals/index', $data);
    }

    public function new()
    {
        $delitosModel = new DelitosModel();
        // Obtener los delitos para mostrarlos en el formulario
        $data['delitos'] = $delitosModel->select('idDelito, tipo')->where('estado', 1)->findAll();

        return view('criminals/newCriminal', $data);
    }

    public function create()
{
    $rules = [
        'nombre' => 'required|max_length[30]',
        'alias' => 'required|max_length[30]',
        'ci' => 'required|max_length[20]|is_unique[criminals.ci]',
        'delitos' => 'required',  // Validamos que se seleccione al menos un delito
        'razon_busqueda' => 'required|max_length[255]',
        'fotos' => 'uploaded[fotos]|max_size[fotos,2048]|ext_in[fotos,jpg,jpeg,png,webp]',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
    }

    $criminalModel = new CriminalsModel();
    $fotosModel = new FotosModel();

    $db = \Config\Database::connect();
    $db->transBegin();

    try {
        // Inserta los datos del criminal
        $criminalData = [
            'nombre' => $this->request->getPost('nombre'),
            'alias' => $this->request->getPost('alias'),
            'ci' => $this->request->getPost('ci'),
            'razon_busqueda' => $this->request->getPost('razon_busqueda'),
            'delitos' => implode(',', $this->request->getPost('delitos')),  // Guardamos los delitos seleccionados como lista separada por comas
            'activo' => 1,
        ];

        $criminalModel->insert($criminalData);
        $idCriminal = $criminalModel->getInsertID();

        // Procesar las fotos
        $files = $this->request->getFiles();
        foreach ($files['fotos'] as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $nombreCriminal = preg_replace('/[^a-zA-Z0-9_-]/', '_', $this->request->getPost('nombre'));

                // Inserta primero los datos de la foto para obtener el idFoto
                $fotoData = [
                    'criminal_id' => $idCriminal,
                    'ruta_foto' => '',  // De momento, lo dejamos vacío
                    'fecha_creacion' => date('Y-m-d H:i:s'),
                ];

                $fotosModel->insert($fotoData);
                $idFoto = $fotosModel->getInsertID();

                // Generar el nombre de la imagen con el idFoto
                $newName = $idFoto . '_' . $nombreCriminal . '_' . $idCriminal . '.' . $file->getClientExtension();
                $file->move('uploads/criminales', $newName);

                // Actualizar la ruta de la foto en la base de datos con el nombre correcto
                $fotosModel->update($idFoto, ['ruta_foto' => $newName]);
            }
        }

        $db->transCommit();
        return redirect()->route('criminals');
    } catch (\Exception $e) {
        $db->transRollback();
        return redirect()->back()->withInput()->with('errors', ['Ocurrió un error al guardar los datos.']);
    }
}



public function edit($idCriminal = null)
{
    if ($idCriminal == null) {
        return redirect()->route('criminals');
    }

    $criminalModel = new CriminalsModel();
    $delitosModel = new DelitosModel();

    // Obtener el criminal y los delitos seleccionados
    $data['criminal'] = $criminalModel->find($idCriminal);
    $data['delitos'] = $delitosModel->select('idDelito, tipo')->where('estado', 1)->findAll();
    $data['delitosSeleccionados'] = explode(',', $data['criminal']['delitos']);  // Convertimos la lista de delitos a un array

    return view('criminals/editCriminal', $data);
}


    public function update($idCriminal = null)
{
    if (!$this->request->is('PUT') || $idCriminal == null) {
        return redirect()->route('criminals');
    }

    $rules = [
        'nombre' => 'required|max_length[30]',
        'alias' => 'required|max_length[30]',
        'ci' => "required|max_length[20]|is_unique[criminals.ci,idCriminal,{$idCriminal}]",
        'delitos' => 'required',  // Validamos que se seleccione al menos un delito
        'razon_busqueda' => 'required|max_length[255]',
        'foto' => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
    }

    $criminalModel = new CriminalsModel();
    $data = [
        'nombre' => $this->request->getPost('nombre'),
        'alias' => $this->request->getPost('alias'),
        'ci' => $this->request->getPost('ci'),
        'delitos' => implode(',', $this->request->getPost('delitos')),  // Guardamos los delitos seleccionados
        'razon_busqueda' => $this->request->getPost('razon_busqueda'),
        'activo' => $this->request->getPost('activo'),
    ];

    $criminalModel->update($idCriminal, $data);
    return redirect()->route('criminals');
}


    public function delete($idCriminal = null)
    {
        if ($idCriminal == null) {
            return redirect()->route('criminals');
        }

        $criminalModel = new CriminalsModel();
        $fotosModel = new FotosModel();
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $criminal = $criminalModel->find($idCriminal);

            $fotos = $fotosModel->where('criminal_id', $idCriminal)->findAll();
            foreach ($fotos as $foto) {
                if (!empty($foto['ruta_foto']) && file_exists(FCPATH . 'uploads/criminales/' . basename($foto['ruta_foto']))) {
                    unlink(FCPATH . 'uploads/criminales/' . basename($foto['ruta_foto']));
                }
            }

            $fotosModel->where('criminal_id', $idCriminal)->delete();
            $criminalModel->delete($idCriminal);

            $db->transCommit();

            return redirect()->route('criminals');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->route('criminals')->with('errors', ['Ocurrió un error al eliminar el criminal.']);
        }
    }

    public function softDelete($idCriminal = null)
    {
        if ($idCriminal == null) {
            return redirect()->route('criminals');
        }

        $criminalModel = new CriminalsModel();
        $criminalModel->update($idCriminal, ['activo' => 0]);

        return redirect()->route('criminals');
    }

    public function habilitar($idCriminal = null)
    {
        if ($idCriminal == null) {
            return redirect()->route('criminals');
        }

        $criminalModel = new CriminalsModel();
        $criminalModel->update($idCriminal, ['activo' => 1]);

        return redirect()->route('criminals');
    }

    public function fotos($idCriminal) {
        // Cargar el modelo de Criminales para obtener las fotos
        $criminalModel = new CriminalsModel();  // Ajusta el namespace del modelo según tu estructura
    
        // Obtener los datos del criminal por ID
        $data['criminal'] = $criminalModel->obtenerCriminalPorId($idCriminal);
    
        // Obtener las fotos del criminal por su ID
        $data['fotos'] = $criminalModel->obtenerFotosPorCriminal($idCriminal);
    
        // Cargar la vista para mostrar las fotos
        return view('criminals/images', $data);
    }

    public function mostrarFotos($idCriminal)
{
    $criminalModel = new CriminalsModel();
    
    // Obtener las fotos del criminal
    $fotos = $criminalModel->obtenerFotosPorCriminal($idCriminal);

    // Verificar si hay fotos
    if (empty($fotos)) {
        return redirect()->back()->with('error', 'No se encontraron fotos para este criminal.');
    }

    // Obtener los detalles del criminal
    $criminal = $criminalModel->find($idCriminal);

    // Verificar si se encontró el criminal
    if (!$criminal) {
        return redirect()->back()->with('error', 'No se encontró información del criminal.');
    }

    // Pasar las fotos y el nombre del criminal a la vista
    return view('criminals/images', [
        'fotos' => $fotos,
        'criminal' => $criminal, // Pasamos el objeto criminal
    ]);
}

    
    
}
