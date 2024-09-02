<?php

namespace App\Controllers;

use CodeIgniter\Files\File;
use App\Controllers\BaseController;
use App\Models\CriminalsModel;

class Criminals extends BaseController
{
    public function index()
    {
        $criminalModel = new CriminalsModel();
        $data['criminales'] = $criminalModel->where('activo', 1)->findAll();
        return view('criminals/index', $data);
    }

    public function new()
    {
        return view('criminals/newCriminal');
    }

    public function create()
    {
        $rules = [
            'nombre' => 'required|max_length[30]',
            'alias' => 'required|max_length[30]',
            'ci' => 'required|max_length[20]|is_unique[criminals.ci]',
            'delitos' => 'required|max_length[255]',
            'razon_busqueda' => 'required|max_length[255]',
            'foto' => 'uploaded[foto]|max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }

        $criminalModel = new CriminalsModel();
        $file = $this->request->getFile('foto');
        $newName = $file->getRandomName();
        $file->move('uploads/criminales', $newName);
        $imageUrl = base_url('uploads/criminales/' . $newName);

        $criminalModel->insert([
            'nombre' => $this->request->getPost('nombre'),
            'alias' => $this->request->getPost('alias'),
            'ci' => $this->request->getPost('ci'),
            'foto' => $imageUrl,
            'delitos' => $this->request->getPost('delitos'),
            'razon_busqueda' => $this->request->getPost('razon_busqueda'),
            'activo' => 1,
        ]);

        return redirect()->route('criminals');
    }

    public function edit($idCriminal = null)
    {
        if ($idCriminal == null) {
            return redirect()->route('criminals');
        }

        $criminalModel = new CriminalsModel();
        $data['criminal'] = $criminalModel->find($idCriminal);

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
            'delitos' => 'required|max_length[255]',
            'razon_busqueda' => 'required|max_length[255]',
            'foto' => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }

        $criminalModel = new CriminalsModel();
        $criminal = $criminalModel->find($idCriminal);

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'alias' => $this->request->getPost('alias'),
            'ci' => $this->request->getPost('ci'),
            'delitos' => $this->request->getPost('delitos'),
            'razon_busqueda' => $this->request->getPost('razon_busqueda'),
            'activo' => $this->request->getPost('activo'),
        ];

        if ($this->request->getFile('foto')->isValid()) {
            $file = $this->request->getFile('foto');
            $newName = $file->getRandomName();
            $file->move('uploads/criminales', $newName);
            $imageUrl = base_url('uploads/criminales/' . $newName);
            $data['foto'] = $imageUrl;
            if (!empty($criminal['foto']) && file_exists(FCPATH . 'uploads/criminales/' . basename($criminal['foto']))) {
                unlink(FCPATH . 'uploads/criminales/' . basename($criminal['foto']));
            }
        }

        $criminalModel->update($idCriminal, $data);

        return redirect()->route('criminals');
    }

    public function delete($idCriminal = null)
    {
        if ($idCriminal == null) {
            return redirect()->route('criminals');
        }

        $criminalModel = new CriminalsModel();
        $criminal = $criminalModel->find($idCriminal);

        if (!empty($criminal['foto']) && file_exists(FCPATH . 'uploads/criminales/' . basename($criminal['foto']))) {
            unlink(FCPATH . 'uploads/criminales/' . basename($criminal['foto']));
        }

        $criminalModel->delete($idCriminal);

        return redirect()->route('criminals');
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
}
