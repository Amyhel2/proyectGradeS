<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Login extends BaseController
{
    //se activa si solo quiero los complementos para este form
    //protected $helpers = ['form'];
    public function index()//: string
    {
        return view('users/login');
    }

    public function auth(){
        $rules=[
            'user'=>'required',
            'password'=>'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }

        $userModel=new UsersModel();
        $post=$this->request->getPost(['user','password']);

        $user=$userModel->validateUser($post['user'],$post['password']);

        if($user !== null){
            $this->setSession($user);
            return redirect()->to(base_url('desktop'));

        }
        return redirect()->back()->withInput()->with('errors','El usuario y/o contrasenia son incorrectos.');


        
    }

    private function setSession($userData){
        $data=[
            'logged_in'=>true,
            'userid'=>$userData['id'],
            'username'=>$userData['nombres'],
        ];
        $this->session->set($data);


    }

    public function logout(){
        if($this->session->get('logged_in')){
            $this->session->destroy();
        }
        return redirect()->to(base_url());
    }


}
