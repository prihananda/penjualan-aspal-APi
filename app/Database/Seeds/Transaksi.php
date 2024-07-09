<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Transaksi extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'transaksi-1',
                'id_client' => '3401123123123123',
                'tgl_transaksi' => '2024-06-01T00:00:00.000',
                'stat_pembayaran' => 0,
                'stat_transaksi' => 0,
                'stat_pengiriman' => 0,
                'tot_transaksi' => 0,
                'tot_tagihan' => 0,
            ]
        ];

        $this->db->table('transaksi')->insertBatch($data);
    }
}