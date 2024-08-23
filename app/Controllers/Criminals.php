<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CriminalsModel;

class Criminals extends BaseController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        //
        $criminalModel= new CriminalsModel();

        $data['criminales'] = $criminalModel->where('activo', 1)->findAll();

        
        return view('criminals/index', $data);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
        return view('criminals/newCriminal');
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        //
        $rules = [
            
            'nombre' => 'required|max_length[30]',
            'alias' => 'required|max_length[30]',
            'ci' => 'required|max_length[20]|is_unique[criminals.ci]',
            //'foto' => 'required|max_length[30]',
            'delitos' => 'required|max_length[255]',
            'razon_busqueda' => 'required|max_length[255]',
            
        ];
    
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }
    
        $criminalModel = new CriminalsModel();
        
        $post = $this->request->getPost([
            'nombre', 'alias', 'ci', 'foto', 'delitos', 'razon_busqueda'
        ]);
    
        $token = bin2hex(random_bytes(20));
    
        //Insercion de los valores del formulario a los campos de la base de datos
    
        $criminalModel->insert([
            
            'nombre' => $post['nombre'],
            
            'alias' => $post['alias'],
            'ci' => $post['ci'],
            'foto' => $post['foto'],
            'delitos' => $post['delitos'],
            'razon_busqueda' => $post['razon_busqueda'],
            
            'activo' => 1
        ]);

        return redirect()->route('criminals');
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($idCriminal = null)
    {
        //
        if($idCriminal == null){
            return redirect()->route('criminals');
        }

        $criminalModel = new CriminalsModel();

        $data['criminal']= $criminalModel->find($idCriminal);

        return view('criminals/editCriminal',$data);
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($idCriminal = null)
    {
        //
        if(!$this->request->is('PUT') || $idCriminal == null){
            return redirect()->route('criminals');
        }

        $rules = [
            
            'nombre' => 'required|max_length[30]',
            'alias' => 'required|max_length[30]',
            'ci' => "required|max_length[20]|is_unique[criminals.ci,idCriminal,{$idCriminal}]",
            //'foto' => 'required|max_length[30]',
            'delitos' => 'required|max_length[255]',
            'razon_busqueda' => 'required|max_length[255]',
            
        ];
    
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }

        $post = $this->request->getPost([
            'nombre', 'alias', 'ci', 'foto', 'delitos', 'razon_busqueda','activo'
        ]);
    
        

        $criminalModel = new CriminalsModel();

        $criminalModel->update($idCriminal, [
            
            'nombre' => $post['nombre'],
            'alias' => $post['alias'],
            'ci' => $post['ci'],
            'foto' => $post['foto'],
            'delitos' => $post['delitos'],
            'razon_busqueda' => $post['razon_busqueda'],
            'activo' => $post['activo']
            
        ]);

        return redirect()->route('criminals');
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($idCriminal = null)
    {
        //
        if (!$this->request->is('DELETE') || $idCriminal == null) {
            return redirect()->route('criminals');
    
        }
    
        $criminalModel = new CriminalsModel();
        $criminalModel->delete($idCriminal);
    
    
        return redirect()->to('criminals');
    }

    public function softDelete($idCriminal)
{
    $criminalModel = new CriminalsModel();
    $data = ['activo' => 0]; // Suponiendo que 'activo' es el campo que indica si el usuario está activo o no.
    $criminalModel->update($idCriminal, $data);

    return redirect()->to(base_url('criminals'))->with('message', 'Criminal desactivado correctamente.');
}
}
