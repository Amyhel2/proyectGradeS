<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GafasModel;
use App\Models\UsersModel;
class Gafas extends BaseController
{
    public function index()
    {
        
        $gafasModel = new GafasModel();
        $data['gafas'] = $gafasModel->where('estado', 1)->findAll();
        
        $data['gafas'] = $gafasModel->getGafasConOficiales();
        // Obtener solo las gafas desactivadas 
        $data['gafasDeshabilitadas'] = $gafasModel->where('estado', 0)->findAll();

        return view('gafas/index', $data);
    }

    public function new()
    {
        return view('gafas/newGafas'); // Mostrar vista para crear nuevas gafas
    }

    public function create()
    {
        $rules = [
            'oficial_id' => 'required|numeric', // Verificar que oficial_id es un número
            'device_id' => 'required|max_length[255]|is_unique[gafas.device_id]', // device_id debe ser único
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }

        $gafasModel = new GafasModel();

        $gafasData = [
            'oficial_id' => $this->request->getPost('oficial_id'),
            'device_id' => $this->request->getPost('device_id'),
        ];

        $gafasModel->insert($gafasData);

        return redirect()->route('gafas');
    }

    public function edit($idGafas = null)
    {
        if ($idGafas == null) {
            return redirect()->route('gafas');
        }

        $gafasModel = new GafasModel();
        $data['gafas'] = $gafasModel->find($idGafas);

        return view('gafas/editGafas', $data);
    }

    

    public function update($idGafas = null)
    {
        if (!$this->request->is('PUT') || $idGafas == null) {
            return redirect()->route('gafas');
        }

        $rules = [
            'oficial_id' => 'required|numeric', 
            'device_id' => "required|max_length[255]|is_unique[gafas.device_id,id,{$idGafas}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }

        $gafasModel = new GafasModel();

        $data = [
            'oficial_id' => $this->request->getPost('oficial_id'),
            'device_id' => $this->request->getPost('device_id'),
        ];

        $gafasModel->update($idGafas, $data);

        return redirect()->route('gafas');
    }

    public function delete($idGafas = null)
    {
        if ($idGafas == null) {
            return redirect()->route('gafas');
        }

        $gafasModel = new GafasModel();
        
        // Comprobar si la gafa existe antes de intentar eliminarla
        $gafa = $gafasModel->find($idGafas);
        if (!$gafa) {
            return redirect()->route('gafas')->with('error', 'El dispositivo no existe.');
        }

        $gafasModel->delete($idGafas);

        return redirect()->route('gafas')->with('success', 'Dispositivo eliminado correctamente.');
    }



    public function softDelete($idGafas)
    {
        $gafaModel = new GafasModel();
        $data = ['estado' => 0]; // Suponiendo que 'activo' es el campo que indica si el usuario está activo o no.
        $gafaModel->update($idGafas, $data);
    
        return redirect()->route('gafas')->with('success', 'Dispositivo desactivado correctamente.');
    }


    public function habilitar($idGafas = null)
    {
        if ($idGafas == null) {
            return redirect()->route('gafas');
        }

        $gafasModel = new GafasModel();

        // Verificar si la gafa existe
        $gafa = $gafasModel->find($idGafas);
        if (!$gafa) {
            return redirect()->route('gafas')->with('error', 'El dispositivo no existe.');
        }

        // Habilitar la gafa (cambiar active a 1)
        $gafasModel->update($idGafas, ['estado' => 1]);

        return redirect()->route('gafas')->with('success', 'Dispositivo habilitado correctamente.');
    }




}


