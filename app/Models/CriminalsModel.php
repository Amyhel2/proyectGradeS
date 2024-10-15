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
        'nombre', 'alias', 'ci', 'razon_busqueda', 'activo'
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

    // Métodos personalizados

    // Método para obtener criminales agrupados por tipo de delito
    public function getCriminalesPorTipo()
    {
        return $this->db->table('criminal_delitos cd')
                        ->select('d.tipo as tipo, COUNT(c.idCriminal) as total')
                        ->join('criminals c', 'cd.criminal_id = c.idCriminal')
                        ->join('delitos d', 'cd.delito_id = d.idDelito')
                        ->groupBy('d.tipo')
                        ->get()
                        ->getResultArray();
    }

    // Método para obtener criminales buscados y su total de delitos
    public function getCriminalesBuscados()
    {
        return $this->db->table('criminals c')
                        ->select('c.idCriminal, c.nombre, COUNT(cd.delito_id) AS total_delitos')
                        ->join('criminal_delitos cd', 'c.idCriminal = cd.criminal_id', 'left')
                        ->groupBy('c.idCriminal')
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
        return $this->db->table('fotos')
                        ->where('criminal_id', $idCriminal)
                        ->get()
                        ->getResultArray();
    }

    // Método para obtener un criminal con sus fotos
    public function obtenerCriminalConFotos($idCriminal)
    {
        return $this->db->table('criminals')
                        ->select('criminals.*, fotos.ruta_foto, fotos.fecha_creacion')
                        ->join('fotos', 'fotos.criminal_id = criminals.idCriminal', 'left')
                        ->where('criminals.idCriminal', $idCriminal)
                        ->get()
                        ->getResultArray();
    }

    // Método para obtener criminales con sus delitos concatenados
    public function getCriminalesConDelitos()
    {
        return $this->db->table('criminals')
                        ->select('criminals.*, GROUP_CONCAT(delitos.tipo) as delitos')
                        ->join('criminal_delitos', 'criminals.idCriminal = criminal_delitos.criminal_id')
                        ->join('delitos', 'criminal_delitos.delito_id = delitos.idDelito')
                        ->groupBy('criminals.idCriminal')
                        ->get()
                        ->getResultArray();
    }
}
