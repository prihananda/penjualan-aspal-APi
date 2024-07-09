<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'unique' => true,
            ],
            'id_client' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'tgl_transaksi' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'stat_pembayaran' => [ // belum dibayar, proses pelunasan, lunas
                'type' => 'INT',
                'null' => false,
            ],
            'stat_transaksi' => [ // menunggu pembayaran , tervalidasi, diproses, selesai
                'type' => 'INT',
                'null' => false,
            ],
            'stat_pengiriman' => [ // menunggu pembayaran ,diproses, dalam perjalanan, diterima
                'type' => 'INT',
                'null' => false,
            ],
            'tot_transaksi' => [
                'type' => 'DOUBLE',
                'null' => false,
            ],
            'tot_tagihan' => [
                'type' => 'DOUBLE',
                'null' => false,
            ],

        ]);

        // Adding Primary Key
        $this->forge->addKey('id', true);

        // Adding Foreign Key Constraint
        $this->forge->addForeignKey('id_client', 'client', 'id', 'CASCADE', 'CASCADE');

        // Creating the Table
        $this->forge->createTable('transaksi', true);
    }

    public function down()
    {
        // Dropping the table if it exists
        $this->forge->dropTable('transaksi', true);
    }
}