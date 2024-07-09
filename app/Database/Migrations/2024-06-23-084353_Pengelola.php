<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengelola extends Migration
{
    public function up()
    {
        // Define fields for the "pengelola" table
        $fields = [
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'unique' => true,
            ],
            'nm_pengelola' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'unique' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
            ],
        ];

        // Add primary key and other keys
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);

        // Create the table
        $this->forge->createTable('pengelola', true);
    }

    public function down()
    {
        // Drop the table if it exists
        $this->forge->dropTable('pengelola', true);
    }
}