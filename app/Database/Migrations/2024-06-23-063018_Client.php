<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Client extends Migration
{
    public function up()
    {
        // Define the fields for the client table
        $this->forge->addField([
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false
            ],
            'nm_pembeli' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => false
            ],
            'no_tlp' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => false
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
        ]);

        // Add primary key
        $this->forge->addKey('nik', true);

        // Create the table
        $this->forge->createTable('client', true);
    }

    public function down()
    {
        // Drop the table if it exists
        $this->forge->dropTable('client', true);
    }
}