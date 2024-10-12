<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoToDetections extends Migration
{
    public function up()
    {
        $this->forge->addColumn('detections', [
            'foto_deteccion' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'ubicacion', // Colocamos la nueva columna después de 'ubicacion'
            ],
        ]);
    }

    public function down()
    {
        // Eliminar la columna en caso de revertir la migración
        $this->forge->dropColumn('detections', 'foto_deteccion');
    }
}
