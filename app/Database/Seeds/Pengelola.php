<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Pengelola extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'pengelola-1',
                'nm_pengelola' => 'Prihananda',
                'username' => 'Nanda',
                'password' => password_hash('nanda123', PASSWORD_DEFAULT),
                'role' => 'admin',
            ]
        ];

        $this->db->table('pengelola')->insertBatch($data);
    }
}