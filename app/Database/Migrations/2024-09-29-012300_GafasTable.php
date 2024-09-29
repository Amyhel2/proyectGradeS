<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GafasTable extends Migration
{
    public function up()
    {
        // Definir los campos de la tabla gafas
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'oficial_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'device_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'estado' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'creado_en' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'actualizado_en' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Definir la clave primaria
        $this->forge->addKey('id', true);

        // Definir la clave única en el campo device_id
        $this->forge->addUniqueKey('device_id');

        // Definir el índice para oficial_id
        $this->forge->addKey('oficial_id');

        // Agregar la clave foránea
        $this->forge->addForeignKey('oficial_id', 'users', 'id', 'CASCADE', 'CASCADE');

        // Crear la tabla gafas
        $this->forge->createTable('gafas');
    }

    public function down()
    {
        // Eliminar la tabla gafas
        $this->forge->dropTable('gafas');
    }
}
