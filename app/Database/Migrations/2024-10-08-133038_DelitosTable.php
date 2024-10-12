<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DelitosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idDelito' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tipo' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'descripcion' => [
                'type'       => 'TEXT',
            ],
            'gravedad' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'estado' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'creado_en' => [
                'type'    => 'DATETIME',
                'null'    => false,
                
            ],
            'actualizado_en' => [
                'type'    => 'DATETIME',
                'null'    => false,
                
            ]
        ]);

        $this->forge->addKey('idDelito', true);
        $this->forge->createTable('delitos');
    }

    public function down()
    {
        $this->forge->dropTable('delitos');
    }
}
