<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table            = 'notifications';
    protected $primaryKey       = 'idNotificacion';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'deteccion_id', 'oficial_id', 'mensaje', 'estado','fecha_envio'
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
    public function getNotificacionesEnviadasLeidas()
    {
        // Contar las notificaciones enviadas y leídas
        return $this->select('estado, COUNT(idNotificacion) as total')
                    ->groupBy('estado')
                    ->findAll();
    }

    public function contarNotificacionesNoLeidas($oficialId)
    {
        return $this->where('oficial_id', $oficialId)
                    ->where('estado', 'enviada')
                    ->countAllResults();
    }

    // Método para actualizar el estado de una notificación a 'leída'
    public function marcarComoLeida($notificacionId)
    {
        return $this->update($notificacionId, ['estado' => 'leida']);
    }
}




 




    