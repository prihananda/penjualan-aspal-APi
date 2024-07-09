<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Penerima extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'penerima-1',
                'id_transaksi' => 'transaksi-1',
                'nm_penerima' => 'Susan',
                'alamat' => 'Purwokerto',
                'no_telp' => '0822314567899'
            ]
        ];

        $this->db->table('penerima')->insertBatch($data);
    }
}