<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nombres' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'apellido_paterno' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'apellido_materno' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'ci' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'unique' => true,
            ],
            'rango' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'numero_placa' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'unique' => true,
            ],
            'fecha_nacimiento' => [
                'type' => 'DATE',
            ],
            'sexo' => [
                'type' => 'ENUM',
                'constraint' => ['M', 'F'],
            ],
            'direccion' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'celular' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 80,
                'unique' => true,
            ],
            'user' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 130,
            ],
            'tipo' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'user'],
                'default' => 'user',
            ],
            'activo' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'token_activacion' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'token_reinicio' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'token_reinicio_expira' => [
                'type' => 'DATETIME',
                'null' => true,
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

        // Crear la tabla
        $this->forge->createTable('users');
    }

    public function down()
    {
        // Eliminar la tabla si se revierte la migración
        $this->forge->dropTable('users');
    }
}
