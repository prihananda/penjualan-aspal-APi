<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Aspal extends Migration
{
    public function up()
    {
        // Define the fields for the Aspal table
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'unique' => true
            ],
            'jenis_aspal' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false
            ],
            'jangka_waktu_pemanasan' => [
                'type' => 'INT',
                'null' => false
            ],
            'satuan' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false
            ],
            'informasi' => [
                'type' => 'VARCHAR',
                'constraint' => 1024,
                'null' => false
            ],
            'harga' => [
                'type' => 'DOUBLE',
                'null' => false
            ],
            'min_order' => [
                'type' => 'INT',
                'null' => false
            ],
            'gambar' => [
                'type' => 'LONGTEXT',
                'null' => false
            ],
            'created_at' => [
                'type' => 'DATE',
                'null' => false
            ],
            'updated_at' => [
                'type' => 'DATE',
                'null' => false
            ]
        ]);

        // Define the primary key
        $this->forge->addKey('id', true);

        // Create the table
        $this->forge->createTable('aspal', true);
    }

    public function down()
    {
        // Drop the table if it exists
        $this->forge->dropTable('aspal', true);
    }
}