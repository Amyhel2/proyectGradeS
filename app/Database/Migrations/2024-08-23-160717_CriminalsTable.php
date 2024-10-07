<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriminalsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idCriminal' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'alias' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'ci' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
                'unique' => true,
            ],
            'delitos' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'razon_busqueda' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'activo' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => false,
            ],
            'creado_en' => [
                'type' => 'DATETIME',
                'null' => false,
                
            ],
            'actualizado_en' => [
                'type' => 'DATETIME',
                'null' => false,
                
            ],
        ]);

        // Agregar clave primaria
        $this->forge->addKey('idCriminal', true); 
        // Crear la tabla
        $this->forge->createTable('criminals');
    }

    public function down()
    {
        // Este método elimina la tabla 'criminals'
        $this->forge->dropTable('criminals');
    }
}
