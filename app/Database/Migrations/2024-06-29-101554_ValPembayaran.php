<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ValPembayaran extends Migration
{
    public function up()
    {
        // Define the fields for the table 'val_pembayaran'
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'unique' => true,
            ],
            'id_pembayaran' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'id_pengelola' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'tgl_val' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'hasil' => [
                'type' => 'INT',
                'null' => false,
            ],
        ]);

        // Define primary key
        $this->forge->addKey('id', true);

        // Add foreign key constraints
        $this->forge->addForeignKey('id_pembayaran', 'pembayaran', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_pengelola', 'pengelola', 'id', 'CASCADE', 'CASCADE');

        // Create the table
        $this->forge->createTable('val_pembayaran', true);
    }

    public function down()
    {
        // Drop the table 'val_pembayaran' if it exists
        $this->forge->dropTable('val_pembayaran', true);
    }
}