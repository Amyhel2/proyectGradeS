<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Login extends BaseController
{
    //se activa si solo quiero los complementos para este form
    //protected $helpers = ['form'];
    public function index()//: string
    {
        return view('login');
    }


}
