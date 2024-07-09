<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penerima extends Migration
{
    public function up()
    {
        // Define the fields for the table 'penerima'
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'unique' => true,
            ],
            'id_transaksi' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'nm_penerima' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'no_telp' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ]
        ]);

        // Define primary key
        $this->forge->addKey('id', true);

        // Add foreign key constraint to 'id_transaksi'
        $this->forge->addForeignKey('id_transaksi', 'transaksi', 'id', 'CASCADE', 'CASCADE');

        // Create the table
        $this->forge->createTable('penerima', true);
    }

    public function down()
    {
        // Drop the table 'penerima' if it exists
        $this->forge->dropTable('penerima', true);
    }
}