<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTipoNotificacionToNotifications extends Migration
{
    public function up()
    {
        // Agregar la columna 'tipo_notificacion' a la tabla 'notifications'
        $this->forge->addColumn('notifications', [
            'tipo_notificacion' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'mensaje', // Define dónde colocar la nueva columna
            ],
        ]);
    }

    public function down()
    {
        // Eliminar la columna 'tipo_notificacion' si se hace rollback
        $this->forge->dropColumn('notifications', 'tipo_notificacion');
    }
}
