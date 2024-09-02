<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NotificationsTable extends Migration
{
    

    public function up()
    {
        $this->forge->addField([
            'idNotificacion' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'deteccion_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'oficial_id' => [
                'type' => 'SMALLINT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'mensaje' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'fecha_envio' => [
                'type' => 'DATETIME',
                'null' => false,
                //'default' => 'CURRENT_TIMESTAMP',
            ],
            'estado' => [
                'type' => 'ENUM',
                'constraint' => ['enviada', 'leida'],
                'default' => 'enviada',
                'null' => false,
            ],
        ]);
        
        // Clave primaria
        $this->forge->addKey('idNotificacion', true);
        
        // Claves foráneas
        $this->forge->addForeignKey('deteccion_id', 'detections', 'idDeteccion', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('oficial_id', 'users', 'id', 'CASCADE', 'CASCADE');

        // Crear la tabla
        $this->forge->createTable('notifications');
    }

    public function down()
    {
        // Eliminar la tabla si se revierte la migración
        $this->forge->dropTable('notifications');
    }
}
