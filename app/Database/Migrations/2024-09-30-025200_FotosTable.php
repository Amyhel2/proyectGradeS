<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FotosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idFoto' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'criminal_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
            ],
            'ruta_foto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'fecha_creacion' => [
                'type'    => 'DATETIME',
                'null'    => false,
                
            ],
        ]);

        // Definir clave primaria
        $this->forge->addKey('idFoto', true);

        // Definir clave foránea para la relación con la tabla `criminals`
        $this->forge->addForeignKey('criminal_id', 'criminals', 'idCriminal', 'CASCADE', 'CASCADE');

        // Crear la tabla
        $this->forge->createTable('fotos');
    }

    public function down()
    {
        // Eliminar la tabla en caso de rollback
        $this->forge->dropTable('fotos');
    }
}
