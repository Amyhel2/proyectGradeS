<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriminalDelitosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'criminal_id' => [
                'type'=> 'INT',
                'unsigned'   => true,
                'null'       => false,
            ],
            'delito_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
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

        // Definir la clave primaria
        $this->forge->addPrimaryKey('id');

        // Definir claves foráneas
        $this->forge->addForeignKey('criminal_id', 'criminals', 'idCriminal', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('delito_id', 'delitos', 'idDelito', 'CASCADE', 'CASCADE');

        $this->forge->createTable('criminal_delitos');
    }

    public function down()
    {
        $this->forge->dropTable('criminal_delitos');
    }
}
