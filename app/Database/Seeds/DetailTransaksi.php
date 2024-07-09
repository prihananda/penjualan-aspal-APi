<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DetailTransaksi extends Seeder
{
    public function run()
    {
        $data = [
            'id' => 'detail-transaksi-1',
            'id_transaksi' => 'transaksi-1',
            'daftar_kendaraan' => 'R9011QWE, R9022RTY',
            'id_aspal' => 'aspal-1',
            'jml_pesanan' => 100
        ];

        $this->db->table('detail_transaksi')->insertBatch($data);
    }
}