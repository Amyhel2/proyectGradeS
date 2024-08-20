<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCriminalsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'foto' => [
                'type' => 'LONGBLOB',
            ],
            'delitos' => [
                'type' => 'TEXT',
            ],
            'razon_busqueda' => [
                'type' => 'TEXT',
            ],
            'fecha_creacion' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('criminales');
    }

    public function down()
    {
        $this->forge->dropTable('criminales');
    }
}
