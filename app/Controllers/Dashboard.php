<?php

namespace App\Controllers;


class Dashboard extends BaseController
{
    public function index()
    {
        return view('index');
        
    }

    public function registro()
    {
        return view('users/register');
        
    }
     
}