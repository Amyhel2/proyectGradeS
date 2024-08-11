<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    //se activa si solo quiero los complementos para este form
    //protected $helpers = ['form'];
    public function index()//: string
    {
        return view('register');
    }



    public function create()
{
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

    $userModel = new UsersModel();
    
    $post = $this->request->getPost([
        'user', 'password', 'nombres', 'apellido_paterno', 'apellido_materno', 'ci', 'rango', 
        'numero_placa', 'fecha_nacimiento', 'genero', 'direccion', 'celular', 'email', 'tipo'
    ]);

    $token = bin2hex(random_bytes(20));

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
        'activo' => 0,
        'token_activacion' => $token
    ]);

    $email = \Config\Services::email();

    $email->setTo($post['email']);
    $email->setSubject('Activa tu cuenta');

    $url = base_url('activate-user/' . $token);
    $body = '<p>Hola ' . $post['nombres'] . '</p>';
    $body .= "<p>Para continuar con el proceso haz click en el siguiente enlace <a href='$url'>Activar cuenta</a></p>";
    $body .= 'Gracias';

    $email->setMessage($body);
    $email->send();

    $title = 'Registro exitoso';
    $message = 'Revisa tu correo electrónico para activar tu cuenta.';
    
    return $this->showMessage($title, $message);
    }

    private function showMessage($title,$message){
        $data=[
            'title'=>$title,
            'message'=>$message,
        ];
        return view('message', $data);

    }

    public function activateUser($token)
    {
        $userModel = new UsersModel();
        $user=$userModel->where(['token_activacion'=>$token, 'activo'=>0])->first();
        if($user){
            $userModel->update(
                $user['id'],
                [
                    'activo'=> 1,
                    'token_activacion'=>''
                ]

            );
            return $this->showMessage('Cuenta activada.','Tu cuenta ha sido activada.');

        }

        return $this->showMessage('Ocurrio un errror.','Por favor intenta nuevamente mas tarde.');
    }
}
