<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailTransaksi extends Migration
{
    public function up()
    {
        // Define the fields for the DetailTransaksi table
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
                'null' => true,
            ],
            'id_aspal' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'daftar_kendaraan' => [
                'type' => 'TEXT',
                'null' => false
            ],
            'jml_pesanan' => [
                'type' => 'INT',
                'null' => false,
            ]
        ]);

        // Add primary key
        $this->forge->addKey('id', true);

        // Add foreign key constraints
        $this->forge->addForeignKey('id_transaksi', 'transaksi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_aspal', 'aspal', 'id', 'CASCADE', 'CASCADE');

        // Create the table
        $this->forge->createTable('detail_transaksi', true);
    }

    public function down()
    {
        // Drop the table if it exists
        $this->forge->dropTable('detail_transaksi', true);
    }
}