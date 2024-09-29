<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NotificationsTable extends Migration
{
    public function up()
    {
        // Crear la tabla notifications
        $this->forge->addField([
            'idNotificacion' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'deteccion_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'oficial_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'mensaje' => [
                'type' => 'TEXT',
                'null' => false,
                'collation' => 'utf8mb4_unicode_ci',
            ],
            'fecha_envio' => [
                'type' => 'DATETIME',
                'null' => false,
                
            ],
            'estado' => [
                'type' => 'ENUM',
                'constraint' => ['enviada', 'leida'],
                'default' => 'enviada',
                'collation' => 'utf8mb4_unicode_ci',
            ],
            'activo' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
        ]);

        // Definir la clave primaria
        $this->forge->addKey('idNotificacion', true);

        // Definir las claves foráneas
        $this->forge->addForeignKey('deteccion_id', 'detections', 'idDeteccion', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('oficial_id', 'users', 'id', 'CASCADE', 'CASCADE');

        // Crear la tabla notifications
        $this->forge->createTable('notifications');
    }

    public function down()
    {
        // Eliminar la tabla notifications
        $this->forge->dropTable('notifications');
    }
}
