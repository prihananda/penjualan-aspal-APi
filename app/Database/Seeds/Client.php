<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Client extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => '3401123123123123',
                'nm_pembeli' => 'John Doe',
                'alamat' => 'Purwokerto',
                'no_tlp' => '081234567890',
                'password' => password_hash('john123', PASSWORD_DEFAULT),
            ],
            [
                'id' => '3401123123123124',
                'nm_pembeli' => 'Jane Doe',
                'alamat' => 'Purwokerto',
                'no_tlp' => '081234567891',
                'password' => password_hash('jane123', PASSWORD_DEFAULT),
            ]
        ];

        $this->db->table('client')->insertBatch($data);

    }
}