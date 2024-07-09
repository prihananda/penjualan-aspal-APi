<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kendaraan extends Migration
{
    public function up()
    {
        // Define the fields for the Kendaraan table
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'unique' => true,
            ],
            'id_aspal' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'tipe' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'maks_cap' => [
                'type' => 'INT',
                'null' => false,
            ],
            'ongkos' => [
                'type' => 'INT',
                'null' => false,
            ]
        ]);

        // Add primary key
        $this->forge->addKey('id', true);

        // Add foreign key constraint
        $this->forge->addForeignKey('id_aspal', 'aspal', 'id', 'CASCADE', 'CASCADE');

        // Create the table
        $this->forge->createTable('kendaraan', true);
    }

    public function down()
    {
        // Drop the table if it exists
        $this->forge->dropTable('kendaraan', true);
    }
}