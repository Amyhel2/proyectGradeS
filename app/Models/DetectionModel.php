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
        'criminal_id', 'oficial_id', 'ubicacion','foto_deteccion', 'confianza','fecha_deteccion'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = null;
    protected $updatedField  = null;
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

    public function getOficialDeteccion()
    {
        return $this->select('detections.*, users.nombres AS nombre_oficial')
                    ->join('users', 'users.id = detections.oficial_id', 'left') // Cambia 'oficiales.id' según tu esquema
                    ->findAll();
    }

    public function getDetections()
    {
        return $this->select('detections.*, CONCAT(users.nombres," ",users.apellido_paterno," ",apellido_materno) AS nombre_oficial, criminals.nombre AS criminal_nombre')
            ->join('users', 'users.id = detections.oficial_id')
            ->join('criminals', 'criminals.idCriminal = detections.criminal_id') // Unir con criminales
            ->findAll();
    }

    public function getDetectionsByZone()
    {
        return $this->select('ubicacion, COUNT(*) as total')
                    ->groupBy('ubicacion')
                    ->orderBy('total', 'DESC')
                    ->findAll();
    }
}




 




    