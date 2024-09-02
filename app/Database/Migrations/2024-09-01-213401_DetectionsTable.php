<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetectionsTable extends Migration
{
    

    public function up()
    {
        $this->forge->addField([
            'idDeteccion' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'criminal_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'oficial_id' => [
                'type' => 'SMALLINT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'fecha_deteccion' => [
                'type' => 'DATETIME',
                'null' => false,
                //'default' => 'CURRENT_TIMESTAMP',
            ],
            'ubicacion' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'confianza' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => false,
            ],
        ]);
        
        // Clave primaria
        $this->forge->addKey('idDeteccion', true);
        
        // Claves foráneas
        $this->forge->addForeignKey('criminal_id', 'criminals', 'idCriminal', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('oficial_id', 'users', 'id', 'CASCADE', 'CASCADE');

        // Crear la tabla
        $this->forge->createTable('detections');
    }

    public function down()
    {
        // Eliminar la tabla si se revierte la migración
        $this->forge->dropTable('detections');
    }
}

