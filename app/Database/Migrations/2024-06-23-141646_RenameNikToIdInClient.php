<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameNikToIdInClient extends Migration
{
    public function up()
    {
        // Define the field renaming operation
        $fields = [
            'nik' => [
                'name' => 'id',      // New field name
                'type' => 'VARCHAR',
                'constraint' => 20   // Adjust constraints as needed
            ],
        ];

        // Modify the table
        $this->forge->modifyColumn('client', $fields);
    }

    public function down()
    {
        // Define the revert operation to rename 'id' back to 'nik'
        $fields = [
            'id' => [
                'name' => 'nik',
                'type' => 'VARCHAR',
                'constraint' => 20   // Ensure this matches the original field definition
            ],
        ];

        // Revert the table changes
        $this->forge->modifyColumn('client', $fields);
    }
}