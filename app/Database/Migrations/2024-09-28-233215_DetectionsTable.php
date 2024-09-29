<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetectionsTable extends Migration
{
    public function up()
    {
        // Definir los campos de la tabla detections
        $this->forge->addField([
            'idDeteccion' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'criminal_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'oficial_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            
            'ubicacion' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'collation' => 'utf8mb4_unicode_ci',
            ],
            'confianza' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => false,
            ],
            'estado' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'fecha_deteccion' => [
                'type' => 'DATETIME',
                'null' => false,
                
            ],
            
        ]);

        // Definir la clave primaria
        $this->forge->addKey('idDeteccion', true);

        // Definir los índices
        $this->forge->addKey('criminal_id');
        $this->forge->addKey('oficial_id');

        // Definir las claves foráneas
        $this->forge->addForeignKey('criminal_id', 'criminals', 'idCriminal', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('oficial_id', 'users', 'id', 'CASCADE', 'CASCADE');

        // Crear la tabla detections
        $this->forge->createTable('detections');
    }

    public function down()
    {
        // Eliminar la tabla detections
        $this->forge->dropTable('detections');
    }
}
