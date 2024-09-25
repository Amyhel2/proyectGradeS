<?php

namespace App\Models;

use CodeIgniter\Model;

class DetectionModel extends Model
{
    protected $table            = 'detections';
    protected $primaryKey       = 'idDeteccion';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'criminal_id', 'oficial_id', 'fecha_deteccion', 'ubicacion', 'confianza'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'creado_en';
    protected $updatedField  = 'actualizado_en';
    /*protected $deletedField  = 'deleted_at';

    // Validation
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


    public function getDeteccionesPorMes()
    {
        // Contar las detecciones agrupadas por mes
        return $this->select('MONTH(fecha_deteccion) as mes, COUNT(idDeteccion) as total')
                    ->groupBy('mes')
                    ->findAll();
    }

    public function getActividadesRecientes()
    {
        // Recuperar las últimas 5 actividades (detecciones recientes)
        return $this->orderBy('fecha_deteccion', 'DESC')
                    ->limit(5)
                    ->findAll();
    }
}




 




    