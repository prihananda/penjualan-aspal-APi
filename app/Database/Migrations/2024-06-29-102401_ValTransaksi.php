<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ValTransaksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'unique' => true,
                'primary_key' => true,
            ],
            'id_pengelola' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'id_transaksi' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'tgl_val' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        // Menambahkan kunci primer
        $this->forge->addKey('id', true);

        // Menambahkan foreign key
        $this->forge->addForeignKey('id_pengelola', 'pengelola', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_transaksi', 'transaksi', 'id', 'CASCADE', 'CASCADE');

        // Membuat tabel
        $this->forge->createTable('val_transaksi');
    }

    public function down()
    {
        // Menghapus tabel
        $this->forge->dropTable('val_transaksi');
    }
}