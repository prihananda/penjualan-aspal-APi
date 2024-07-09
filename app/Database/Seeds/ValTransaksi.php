<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ValTransaksi extends Seeder
{
    public function run()
    {
        $data = [
            'id' => 'val-transaksi-1',
            'id_transaksi' => 'transaksi-1',
            'id_pengelola' => 'pengelola-1',
            'tgl_val' => '2023-06-29'
        ];

        $this->db->table('val_transaksi')->insertBatch($data);
    }
}