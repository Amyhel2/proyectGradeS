<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'ci',
        'rango',
        'numero_placa',
        'fecha_nacimiento',
        'sexo',
        'direccion',
        'celular',
        'email',
        'user',
        'password',
        'tipo',
        'activo',
        'token_activacion',
        'token_reinicio',
        'token_reinicio_expira'
    ];
    

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'creado_en';
    protected $updatedField = 'actualizado_en';

    

    public function validateUser($user,$password){
        $user=$this->where(['user'=>$user,'activo'=>1])->first();
        if($user && password_verify($password,$user['password'])){
            return $user;

        }
        return null;

    }


    //protected $deletedField  = 'deleted_at';

    /* Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];*/
}
