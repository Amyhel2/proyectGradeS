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





    private function showMessage($title,$message){
        $data=[
            'title'=>$title,
            'message'=>$message,
        ];
        return view('users/message', $data);

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

    public function linkRequestForm(){
        return view('users/link_request');

    }

    public function sendResetLinkEmail(){
        $rules=[
            'email'=>'required|max_length[80]|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }

        $userModel = new UsersModel();

        $post=$this->request->getPost(['email']);

        $user=$userModel->where(['email'=>$post['email'],'activo'=>1])->first();
        
        if($user){
            $token = bin2hex(random_bytes(20));
            $expiresAt=new \DateTime();
            $expiresAt->modify('+3 hour');
            $userModel->update($user['id'],[
                
                'token_reinicio'=>$token,
                'token_reinicio_expira'=>$expiresAt->format('Y-m-d H:i:s'),
            ]);

            $email = \Config\Services::email();

            $email->setTo($post['email']);
            $email->setSubject('Recuperar contrasena');

            $url = base_url('password-reset/' . $token);

            $body = '<p>Estimad@ ' . $user['nombres'] . '</p>';
            $body .= "<p>Se ha solicitado un reinicio de contrasena.<br>Para restablecer su contrasena ingrese al siguiente enlace:
              <a href='$url'>$url</a></p>";
    

            $email->setMessage($body);
            $email->send();
    }

    $title = 'Correo de recuperacion enviado.';
    $message = 'Se ha enviado un correo electronico con instrucciones para restablecer tu contrasena.';
    
    return $this->showMessage($title, $message);     

    }

    public function resetForm($token){
        $userModel = new UsersModel();
        $user=$userModel->where(['token_reinicio'=>$token])->first();
        if($user){
            $currentDateTime=new \DateTime();
            $currentDateTimeStr=$currentDateTime->format('Y-m-d H:i:s');

            if($currentDateTimeStr <= $user['token_reinicio_expira']){
                return view('users/reset_password',['token'=>$token]);

            }else{
                return $this->showMessage('El mensaje ha expirado','Por favor solicita un nuevo enlace para restablecer tu contrasena.');

            }

        }
        return $this->showMessage('Ocurrio un error.','Por favor intenta nuevamente mas tarde.');

    }

    public function resetPassword(){
        
        $rules = [
            
            'password' => 'required|min_length[8]|max_length[255]',
            'repassword' => 'matches[password]',
            
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }
    
        $userModel = new UsersModel();
        $post=$this->request->getPost(['token','password']);

        
        $user=$userModel->where(['token_reinicio'=>$post['token'], 'activo'=>1])->first();

        if($user){

            $userModel->update($user['id'],[
                'password' => password_hash($post['password'], PASSWORD_DEFAULT),
                'token_reinicio'=>'',
                'token_reinicio_expira'=>'',
            ]);

            return $this->showMessage('Contrasena modificada.','Hemos modificado la contrasena.');
        }

        return $this->showMessage('Ocurrio un error.','Por favor intenta de nuevo mas tarde.');

    }

}
