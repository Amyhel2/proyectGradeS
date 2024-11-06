<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Users extends BaseController
{

    protected $helpers=['form'];


    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $userModel= new UsersModel();
        
        $data['usuarios'] = $userModel->where('activo', 1)->findAll();
        // Obtener solo los usuarios desactivados
    $data['desactivados'] = $userModel->where('activo', 0)->findAll();

        return view('users/index', $data);
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
        'user' => [
            'rules' => 'required|min_length[6]|max_length[20]|is_unique[users.user]',
            'errors' => [
                'required' => 'El nombre de usuario es obligatorio.',
                'min_length' => 'El nombre de usuario debe tener al menos 6 caracteres.',
                'max_length' => 'El nombre de usuario no debe exceder 20 caracteres.',
                'is_unique' => 'El nombre de usuario ya está registrado.'
            ]
        ],
        'password' => [
            'rules' => 'required|min_length[8]|max_length[255]|regex_match[/(?=.*\d)(?=.*[A-Z])(?=.*\W)/]',
            'errors' => [
                'required' => 'La contraseña es obligatoria.',
                'min_length' => 'La contraseña debe tener al menos 8 caracteres.',
                'regex_match' => 'La contraseña debe contener al menos un número, una letra mayúscula y un carácter especial.'
            ]
        ],
        'repassword' => [
            'rules' => 'matches[password]',
            'errors' => [
                'matches' => 'La confirmación de la contraseña no coincide.'
            ]
        ],
        'nombres' => [
            'rules' => 'required|max_length[30]',
            'errors' => [
                'required' => 'El nombre es obligatorio.',
                'max_length' => 'El nombre no debe exceder 20 caracteres.'
            ]
        ],
        'apellido_paterno' => [
            'rules' => 'required|max_length[20]',
            'errors' => [
                'required' => 'El apellido paterno es obligatorio.',
                'max_length' => 'El apellido paterno no debe exceder 20 caracteres.'
            ]
        ],
        'apellido_materno' => [
            'rules' => 'required|max_length[20]',
            'errors' => [
                'required' => 'El apellido materno es obligatorio.',
                'max_length' => 'El apellido materno no debe exceder 20 caracteres.'
            ]
        ],
        'ci' => [
            'rules' => 'required|min_length[7]|max_length[8]|is_unique[users.ci]',
            'errors' => [
                'required' => 'El CI es obligatorio.',
                'is_unique' => 'El CI ya está registrado.',
                'min_length' => 'El CI no debe ser menor a 7 caracteres.',
                'max_length' => 'El CI no debe exceder 8 caracteres.'
            ]
        ],
        'rango' => [
                'rules' => 'required|min_length[4]|max_length[20]|regex_match[/^[a-zA-Z\s]+$/]',
                'errors' => [
                    'required' => 'El rango es obligatorio.',
                    'regex_match' => 'El rango no debe contener n-umeros ni caracteres especiales.',
                    'min_length' => 'El rango no debe ser menor a 4 caracteres.',
                    'max_length' => 'El rango no debe exceder 20 caracteres.'
                ]
            ],
        'numero_placa' => [
            'rules' => 'required|exact_length[6]|is_unique[users.numero_placa]',
            'errors' => [
                'required' => 'El número de placa es obligatorio.',
                'is_unique' => 'El número de placa ya está registrado.',
                'exact_length' => 'El número de placa debe contener solo 6 caracteres.'
            ]
        ],
        'fecha_nacimiento' => [
            'rules' => 'required|valid_date[Y-m-d]',
            'errors' => [
                'required' => 'La fecha de nacimiento es obligatoria.',
                'valid_date' => 'La fecha de nacimiento debe tener un formato válido (YYYY-MM-DD).'
            ]
        ],
        'sexo' => [
            'rules' => 'required|in_list[M,F]',
            'errors' => [
                'required' => 'El sexo es obligatorio.',
                'in_list' => 'El sexo debe ser M (Masculino) o F (Femenino).'
            ]
        ],
        'direccion' => [
            'rules' => 'required|max_length[100]',
            'errors' => [
                'required' => 'La dirección es obligatoria.',
                'max_length' => 'La dirección no debe exceder 100 caracteres.'
            ]
        ],
        'celular' => [
            'rules' => 'required|exact_length[11]|numeric',
            'errors' => [
                'required' => 'El número de celular es obligatorio.',
                'numeric' => 'El número de celular debe contener 11 dígitos numéricos.',
                'exact_length' => 'El número de celular no debe exceder 11 caracteres y debe incluir el codigo del pais.'
            ]
        ],
        'email' => [
            'rules' => 'required|max_length[80]|valid_email|is_unique[users.email]',
            'errors' => [
                'required' => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Debe ingresar un correo electrónico válido.',
                'is_unique' => 'El correo electrónico ya está registrado.',
                'max_length' => 'El correo electrónico no debe exceder 80 caracteres.'
            ]
        ],
        'tipo' => [
            'rules' => 'required|in_list[admin,user]',
            'errors' => [
                'required' => 'El tipo de usuario es obligatorio.',
                'in_list' => 'El tipo de usuario debe ser admin o user.'
            ]
        ]
    ];
    

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
    }

    $userModel = new UsersModel();
    
    $post = $this->request->getPost([
        'user', 'password', 'nombres', 'apellido_paterno', 'apellido_materno', 'ci', 'rango', 
        'numero_placa', 'fecha_nacimiento', 'sexo', 'direccion', 'celular', 'email', 'tipo'
    ]);

    $token = bin2hex(random_bytes(20));

    //Insercion de los valores del formulario a los campos de la base de datos

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
        'sexo' => $post['sexo'],
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

    //$title = 'Registro exitoso';
    //$message = 'Revisa tu correo electrónico para activar tu cuenta.';
    
    //return $this->showMessage($title, $message);
    //return redirect()->route('usuarios');
    
    // Establecer mensajes flashdata
    $this->session->setFlashdata('message', 'Usuario creado con éxito');
    $this->session->setFlashdata('message_type', 'success');

    // Redirigir al listado de usuarios
    return redirect()->route('users');
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
        if($id == null){
            return redirect()->route('users');
        }

        $userModel = new UsersModel();

        $data['usuario']= $userModel->find($id);

        return view('users/editUser',$data);
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
        if(!$this->request->is('PUT') || $id == null){
            return redirect()->route('users');
        }

        $rules = [
            
            'nombres' => [
                'rules' => 'required|max_length[30]',
                'errors' => [
                    'required' => 'El nombre es obligatorio.',
                    'max_length' => 'El nombre no debe exceder 30 caracteres.'
                ]
            ],
            'apellido_paterno' => [
                'rules' => 'required|max_length[30]',
                'errors' => [
                    'required' => 'El apellido paterno es obligatorio.',
                    'max_length' => 'El apellido paterno no debe exceder 30 caracteres.'
                ]
            ],
            'apellido_materno' => [
                'rules' => 'required|max_length[30]',
                'errors' => [
                    'required' => 'El apellido materno es obligatorio.',
                    'max_length' => 'El apellido materno no debe exceder 30 caracteres.'
                ]
            ],
            'ci' => [
            'rules' => "required|min_length[7]|max_length[8]|is_unique[users.ci,id,{$id}]",
            'errors' => [
                'required' => 'El CI es obligatorio.',
                'is_unique' => 'El CI ya está registrado.',
                'min_length' => 'El CI no debe ser menor a 7 caracteres.',
                'max_length' => 'El CI no debe exceder 8 caracteres.'
            ]
        ],
            
            'rango' => [
                'rules' => 'required|min_length[4]|max_length[20]|regex_match[/^[a-zA-Z\s]+$/]',
                'errors' => [
                    'required' => 'El rango es obligatorio.',
                    'regex_match' => 'El rango no debe contener n-umeros ni caracteres especiales.',
                    'min_length' => 'El rango no debe ser menor a 4 caracteres.',
                    'max_length' => 'El rango no debe exceder 20 caracteres.'
                ]
            ],
            
            'fecha_nacimiento' => [
                'rules' => 'required|valid_date[Y-m-d]',
                'errors' => [
                    'required' => 'La fecha de nacimiento es obligatoria.',
                    'valid_date' => 'La fecha de nacimiento debe tener un formato válido (YYYY-MM-DD).'
                ]
            ],
            'direccion' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'La dirección es obligatoria.',
                    'max_length' => 'La dirección no debe exceder 255 caracteres.'
                ]
            ],
            'celular' => [
                'rules' => 'required|exact_length[11]|numeric',
                'errors' => [
                'required' => 'El número de celular es obligatorio.',
                'numeric' => 'El número de celular debe contener 11 dígitos numéricos.',
                'exact_length' => 'El número de celular debe contener 11 dígitos y debe incluir el codigo del pais.'
            ]
            ],
            'email' => [
                'rules' => "required|max_length[80]|valid_email|is_unique[users.email,id,{$id}]",
                'errors' => [
                    'required' => 'El correo electrónico es obligatorio.',
                    'valid_email' => 'Debe ingresar un correo electrónico válido.',
                    'is_unique' => 'El correo electrónico ya está registrado.',
                    'max_length' => 'El correo electrónico no debe exceder 80 caracteres.'
                ]
            ],
            'tipo' => [
                'rules' => 'required|in_list[admin,user]',
                'errors' => [
                    'required' => 'El tipo de usuario es obligatorio.',
                    'in_list' => 'El tipo de usuario debe ser admin o user.'
                ]
            ]
        ];
        
    
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }
    
        $post = $this->request->getPost([
            'nombres', 'apellido_paterno', 'apellido_materno', 'ci', 'rango', 
            'numero_placa', 'fecha_nacimiento', 'direccion', 'celular', 'email', 'tipo','activo'
        ]);

        $userModel = new UsersModel();

        $userModel->update($id, [
            //'user' => $post['user'],
            
            //'password' => password_hash($post['password'], PASSWORD_DEFAULT),

            'nombres' => $post['nombres'],
            'apellido_paterno' => $post['apellido_paterno'],
            'apellido_materno' => $post['apellido_materno'],
            'ci' => $post['ci'],
            'rango' => $post['rango'],
            'numero_placa' => $post['numero_placa'],
            'fecha_nacimiento' => $post['fecha_nacimiento'],
            //'sexo' => $post['sexo'],
            'direccion' => $post['direccion'],
            'celular' => $post['celular'],
            'email' => $post['email'],
            'tipo' => $post['tipo'],
            'activo' => $post['activo']
            //'token_activacion' => $token
        ]);

        $this->session->setFlashdata('message', 'Usuario actualizado con éxito.');
    $this->session->setFlashdata('message_type', 'success');


        return redirect()->route('users');
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
        if ($id == null) {
            return redirect()->route('users');
        }

        $userModel = new UsersModel();
        
        // Comprobar si la gafa existe antes de intentar eliminarla
        $usuario = $userModel->find($id);
        if (!$usuario) {
            return redirect()->route('users')->with('error', 'El usuario no existe.');
        }

        $userModel->delete($id);

        return redirect()->route('users')->with('success', 'Usuario eliminado correctamente.');
    }

    

    public function softDelete($id)
    {
        $userModel = new UsersModel();
        $data = ['activo' => 0]; // Suponiendo que 'activo' es el campo que indica si el usuario está activo o no.
        $userModel->update($id, $data);
    
        return redirect()->route('users')->with('success', 'Usuario desactivado correctamente.');
    }

    /*Funciones extras*/

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

        return $this->showMessage('Ocurrio un error.','Por favor intenta nuevamente mas tarde.');
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
            $expiresAt->modify('+1 hour');
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

    

    public function desactivados()
    {
        $model = new UsersModel();
        // Obtener solo los usuarios inactivos
        $data['desactivados'] = $model->where('activo', 0)->findAll();
        
        return view('users/desactivados', $data); // Asegúrate de crear esta vista
    }
    

    public function reactivateUser($id)
    {
        $model = new UsersModel();
        
        // Cambiar el estado del usuario a activo
        $data = [
            'activo' => 1, // Cambia el campo 'activo' a 1
        ];
        
        $model->update($id, $data);
        
        // Redirigir después de reactivar
        return redirect()->to('/users')->with('success', 'Usuario reactivado correctamente.');
    }



    public function generarReportePDF()
{
    // Obtener usuarios activos
    $userModel = new UsersModel();
    $usuarios = $userModel->where('activo', 1)->findAll();

    // Cargar la vista con los datos
    $data = [
        'usuarios' => $usuarios,
    ];

    $html = view('reports/index', $data);

    // Configurar Dompdf
    $options = new Options();
    $options->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    // Enviar el PDF al navegador
    $dompdf->stream('reporte_usuarios.pdf', ['Attachment' => false]);
}

}
