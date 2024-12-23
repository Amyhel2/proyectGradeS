<?php

namespace App\Models;

use CodeIgniter\Model;

class GafasModel extends Model
{
    protected $table            = 'gafas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'oficial_id', 'device_id','estado'
        ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'creado_en';
    protected $updatedField  = 'actualizado_en';
    // protected $deletedField  = 'deleted_at';

    // Validation (opcional)
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // Callbacks (opcional)
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];

    public function getGafasPorOficial()
    {
        // Contar las gafas agrupadas por oficial
        return $this->select('oficial_id, COUNT(id) as total')
                    ->groupBy('oficial_id')
                    ->findAll();
    }

    public function getGafasConOficiales()
{
    return $this->select('gafas.*, CONCAT(users.nombres, " ", users.apellido_paterno," ", users.apellido_materno) AS nombre_oficial')
                ->join('users', 'users.id = gafas.oficial_id')
                ->where('gafas.estado', 1)
                ->findAll();
}
}
