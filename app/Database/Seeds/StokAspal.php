<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StokAspal extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'stok-1',
                'id_aspal' => 'aspal-1',
                'jumlah' => 5000,
                'tanggal' => '2024-06-01T00:00:00.000',
                'status' => 1
            ],
            [
                'id' => 'stok-2',
                'id_aspal' => 'aspal-2',
                'jumlah' => 1000,
                'tanggal' => '2024-06-01T00:00:00.000',
                'status' => 1
            ],
        ];

        $this->db->table('stok_aspal')->insertBatch($data);
    }
}