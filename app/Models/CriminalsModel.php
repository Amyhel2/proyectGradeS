<?php

namespace App\Models;

use CodeIgniter\Model;

class CriminalsModel extends Model
{
    protected $table            = 'criminals';
    protected $primaryKey       = 'idCriminal';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'nombre','alias', 'ci', 'delitos', 'razon_busqueda', 'activo'
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


    public function getCriminalesPorTipo()
    {
        // Contar los criminales agrupados por tipo de delito
        return $this->select('delitos as tipo, COUNT(idCriminal) as total')
                    ->groupBy('tipo')
                    ->findAll();
    }


    public function getCriminalesBuscados()
    {
        return $this->db->table('criminals c')
            ->select('c.id, c.nombre, c.foto, d.tipo_delito, COUNT(d.id) AS total_delitos')
            ->join('delitos d', 'c.id = d.criminal_id', 'left')
            ->groupBy('c.id, d.tipo_delito')
            ->orderBy('total_delitos', 'DESC')
            ->get()
            ->getResultArray();
    }

    // Método para obtener un criminal por su ID
    public function obtenerCriminalPorId($idCriminal)
    {
        return $this->where('idCriminal', $idCriminal)->first();
    }

    // Método para obtener las fotos asociadas a un criminal
    public function obtenerFotosPorCriminal($idCriminal)
    {
        $builder = $this->db->table('fotos');
        return $builder->where('criminal_id', $idCriminal)->get()->getResultArray();
    }

    public function obtenerCriminalConFotos($idCriminal)
    {
        $builder = $this->db->table('criminals');
        $builder->select('criminals.*, fotos.ruta_foto, fotos.fecha_creacion');
        $builder->join('fotos', 'fotos.criminal_id = criminals.idCriminal', 'left');
        $builder->where('criminals.idCriminal', $idCriminal);
        return $builder->get()->getResultArray();
    }

    
}




 




    