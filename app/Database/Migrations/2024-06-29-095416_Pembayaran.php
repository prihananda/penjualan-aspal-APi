<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pembayaran extends Migration
{
    public function up()
    {
        // Define the fields for the table 'pembayaran'
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
            'bukti_bayar' => [
                'type' => 'TEXT',
                'null' => true, // Assuming that the payment proof might not be available at the time of creation
            ],
            'tgl_bayar' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'nominal_bayar' => [
                'type' => 'DOUBLE',
                'null' => false,
            ],
            'ket_bayar' => [
                'type' => 'TEXT',
                'null' => true,
            ]
        ]);

        // Define primary key
        $this->forge->addKey('id', true);

        // Add foreign key constraint to 'id_transaksi'
        $this->forge->addForeignKey('id_transaksi', 'transaksi', 'id', 'CASCADE', 'CASCADE');

        // Create the table
        $this->forge->createTable('pembayaran', true);
    }

    public function down()
    {
        // Drop the table 'pembayaran' if it exists
        $this->forge->dropTable('pembayaran', true);
    }
}