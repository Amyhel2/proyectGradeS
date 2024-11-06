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
        $data['gafas'] = $gafasModel->getGafasConOficiales();
        $data['gafasDeshabilitadas'] = $gafasModel->where('estado', 0)->findAll();

        return view('gafas/index', $data);
    }

    public function new()
    {
        $usersModel = new UsersModel();
        $data['oficiales'] = $usersModel->where('activo', 1)->findAll();
        
        return view('gafas/newGafas', $data);
    }

    public function create()
    {
        $rules = [
            'oficial_id' => 'required|numeric', 
            'device_id'  => 'required|max_length[255]|is_unique[gafas.device_id]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }

        $gafasModel = new GafasModel();
        $gafasData = [
            'oficial_id' => $this->request->getPost('oficial_id'),
            'device_id'  => $this->request->getPost('device_id'),
            'estado'     => $this->request->getPost('estado') ?? 1,
        ];

        if (!$gafasModel->insert($gafasData)) {
            return redirect()->back()->withInput()->with('error', 'Error al crear el dispositivo.');
        }

        return redirect()->route('gafas')->with('success', 'Dispositivo creado correctamente.');
    }

    public function edit($idGafas = null)
    {
        if ($idGafas === null) {
            return redirect()->route('gafas');
        }

        $gafasModel = new GafasModel();
        $data['gafas'] = $gafasModel->find($idGafas);

        if (!$data['gafas']) {
            return redirect()->route('gafas')->with('error', 'El dispositivo no existe.');
        }

        $usersModel = new UsersModel();
        $data['oficiales'] = $usersModel->where('activo', 1)->findAll();

        return view('gafas/editGafas', $data);
    }

    public function update($idGafas = null)
    {
        if (!$this->request->getMethod() === 'post' || $idGafas === null) {
            return redirect()->route('gafas');
        }

        $rules = [
            'oficial_id' => 'required|numeric',
            'device_id'  => "required|max_length[255]|is_unique[gafas.device_id,id,{$idGafas}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }

        $gafasModel = new GafasModel();
        $data = [
            'oficial_id' => $this->request->getPost('oficial_id'),
            'device_id'  => $this->request->getPost('device_id'),
            'estado'     => $this->request->getPost('estado') ?? 1,
        ];

        if (!$gafasModel->update($idGafas, $data)) {
            return redirect()->back()->with('error', 'Error al actualizar el dispositivo.');
        }

        return redirect()->route('gafas')->with('success', 'Dispositivo actualizado correctamente.');
    }

    public function delete($idGafas = null)
    {
        if ($idGafas == null) {
            return redirect()->route('gafas');
        }

        $gafasModel = new GafasModel();

        if (!$gafasModel->delete($idGafas)) {
            return redirect()->route('gafas')->with('error', 'El dispositivo no existe o no se pudo eliminar.');
        }

        return redirect()->route('gafas')->with('success', 'Dispositivo eliminado correctamente.');
    }

    public function softDelete($idGafas)
    {
        $gafasModel = new GafasModel();
        $data = ['estado' => 0]; // Cambiar el estado a 0 para deshabilitar

        if (!$gafasModel->update($idGafas, $data)) {
            return redirect()->route('gafas')->with('error', 'Error al desactivar el dispositivo.');
        }

        return redirect()->route('gafas')->with('success', 'Dispositivo desactivado correctamente.');
    }

    public function habilitar($idGafas = null)
    {
        if ($idGafas == null) {
            return redirect()->route('gafas');
        }

        $gafasModel = new GafasModel();
        $gafa = $gafasModel->find($idGafas);

        if (!$gafa) {
            return redirect()->route('gafas')->with('error', 'El dispositivo no existe.');
        }

        if (!$gafasModel->update($idGafas, ['estado' => 1])) {
            return redirect()->route('gafas')->with('error', 'Error al habilitar el dispositivo.');
        }

        return redirect()->route('gafas')->with('success', 'Dispositivo habilitado correctamente.');
    }
}
