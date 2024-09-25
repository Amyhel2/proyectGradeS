<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Login extends BaseController
{
    protected $helpers = ['form'];

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
        $data = [
            'logged_in' => true,
            'userid' => $userData['id'],
            'username' => $userData['nombres'],
            'rol' => $userData['tipo'],
        ];
        session()->set($data);
    }

    public function logout()
    {
        if (session()->get('logged_in')) {
            session()->destroy();
        }
        return redirect()->to(base_url());
    }

    public function changePassword()
    {
        return view('users/userConfig');
    }


    private function showMessage($title,$message){
        $data=[
            'title'=>$title,
            'message'=>$message,
        ];
        return view('users/message', $data);

    }


    public function updatePassword()
{
    $rules = [
        'current_password' => 'required',
        'new_password' => 'required|min_length[8]',
        'confirm_password' => 'required|matches[new_password]',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
    }

    $userModel = new UsersModel();
    $current_password = $this->request->getPost('current_password');
    $new_password = $this->request->getPost('new_password');
    $user = $userModel->find($this->session->get('userid'));

    // Verificar si la contraseña actual es correcta
    if (!password_verify($current_password, $user['password'])) {
        return redirect()->back()->with('errors', 'La contraseña actual es incorrecta');
    }

    // Actualizar la contraseña en la base de datos
    $userModel->update($user['id'], [
        'password' => password_hash($new_password, PASSWORD_DEFAULT)
    ]);

    $title = 'Contraseña Actualizada';
    $message = 'Su contraseña se ha actualizado correctamente.';

    return $this->showMessage($title, $message);
}


}
