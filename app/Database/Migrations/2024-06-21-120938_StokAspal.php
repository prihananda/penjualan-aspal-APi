<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StokAspal extends Migration
{
    public function up()
    {
        // Define the fields for the StokAspal table
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'unique' => true
            ],
            'id_aspal' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false
            ],
            'jumlah' => [
                'type' => 'INT',
                'null' => false
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => false
            ],
            'status' => [
                'type' => 'INT',
                'null' => false
            ]
        ]);

        // Define the primary key
        $this->forge->addKey('id', true);

        // Define the foreign key
        $this->forge->addForeignKey('id_aspal', 'aspal', 'id', 'CASCADE', 'CASCADE');

        // Create the table
        $this->forge->createTable('stok_aspal', true);
    }

    public function down()
    {
        // Drop the table if it exists
        $this->forge->dropTable('stok_aspal', true);
    }
}