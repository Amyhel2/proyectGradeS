<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class Users extends BaseController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        //
        return view('users/index');
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
        return view('users/newUser');
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
            'user' => 'required|max_length[30]|is_unique[users.user]',
            'password' => 'required|min_length[8]|max_length[255]',
            'repassword' => 'matches[password]',
            'nombres' => 'required|max_length[30]',
            'apellido_paterno' => 'required|max_length[30]',
            'apellido_materno' => 'required|max_length[30]',
            'ci' => 'required|max_length[20]|is_unique[users.ci]',
            'rango' => 'required|max_length[20]',
            'numero_placa' => 'required|max_length[20]|is_unique[users.numero_placa]',
            'fecha_nacimiento' => 'required|valid_date[Y-m-d]',
            'genero' => 'required|in_list[M,F]',
            'direccion' => 'required|max_length[255]',
            'celular' => 'required|max_length[15]|numeric',
            'email' => 'required|max_length[80]|valid_email|is_unique[users.email]',
            'tipo' => 'required|in_list[admin,user]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }
    
    
        
        $post = $this->request->getPost([
            'user', 'password', 'nombres', 'apellido_paterno', 'apellido_materno', 'ci', 'rango', 
            'numero_placa', 'fecha_nacimiento', 'genero', 'direccion', 'celular', 'email', 'tipo'
        ]);
        $userModel = new UsersModel();
    
        $userModel->insert([
            'user' => $post['user'],
            'password' => password_hash($post['password'], PASSWORD_DEFAULT),
            'nombres' => $post['nombres'],
            'apellido_paterno' => $post['apellido_paterno'],
            'apellido_materno' => $post['apellido_materno'],
            'ci' => $post['ci'],
            'rango' => $post['rango'],
            'numero_placa' => $post['numero_placa'],
            'fecha_nacimiento' => $post['fecha_nacimiento'],
            'genero' => $post['genero'],
            'direccion' => $post['direccion'],
            'celular' => $post['celular'],
            'email' => $post['email'],
            'tipo' => $post['tipo'],
            
        ]);
    
       
        
        return redirect()->to('users');
        
    
    
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
