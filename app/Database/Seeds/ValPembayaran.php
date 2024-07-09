<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ValPembayaran extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'val-pembayaran-1',
                'id_pembayaran' => 'pembayaran-1',
                'id_pengelola' => 'pengelola-1',
                'tgl_val' => '2023-07-1',
                
            ],
            [
                'id' => 'val-pembayaran-2',
                'id_pembayaran' => 'pembayaran-2',
                'id_pengelola' => 'pengelola-1',
                'tgl_val' => '2023-07-2',
                
            ],
        ];

        $this->db->table('val_pembayaran')->insertBatch($data);
    }
}