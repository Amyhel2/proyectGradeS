<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Login extends BaseController
{
    // Si solo necesitas helpers específicos, descomenta esto
    // protected $helpers = ['form'];

    public function index()
    {
        return view('users/login');
    }

    public function auth()
    {
        $rules = [
            'user' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }

        $userModel = new UsersModel();
        $post = $this->request->getPost(['user', 'password']);

        $user = $userModel->validateUser($post['user'], $post['password']);

        if ($user !== null) {
            $this->setSession($user);
            return redirect()->to(base_url('start'));
        }

        return redirect()->back()->withInput()->with('errors', 'El usuario y/o contraseña son incorrectos.');
    }

    private function setSession($userData)
    {
        // Asegúrate de que el rol esté presente en los datos del usuario
        $data = [
            'logged_in' => true,
            'userid' => $userData['id'],
            'username' => $userData['nombres'],
            'rol' => $userData['tipo'], // Guardar el rol del usuario en la sesión
        ];
        $this->session->set($data);
    }

    public function logout()
    {
        if ($this->session->get('logged_in')) {
            $this->session->destroy();
        }
        return redirect()->to(base_url());
    }
}
