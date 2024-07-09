<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Kendaraan extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'R9011QWE',
                'id_aspal' => 'aspal-1',
                'tipe' => 'Colt Diesel',
                'maks_cap' => 50,
                'ongkos' => 750000
            ],
            [
                'id' => 'R9022RTY',
                'id_aspal' => 'aspal-1',
                'tipe' => 'Colt Diesel',
                'maks_cap' => 50,
                'ongkos' => 750000
            ],
            [
                'id' => 'R9033UIO',
                'id_aspal' => 'aspal-2',
                'tipe' => 'Tronton',
                'maks_cap' => 190,
                'ongkos' => 500000
            ],
            [
                'id' => 'R9044PAS',
                'id_aspal' => 'aspal-2',
                'tipe' => 'Tronton',
                'maks_cap' => 190,
                'ongkos' => 500000
            ],


        ];

        $this->db->table('kendaraan')->insertBatch($data);
    }
}