<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAspalProcedure extends Migration
{
    public function up()
    {
        $this->db->query("
             CREATE PROCEDURE AddAspal(
                IN p_id VARCHAR(255),
                IN p_id_stok_aspal VARCHAR(255),
                IN p_jenis_aspal VARCHAR(255),
                IN p_jangka_waktu_pemanasan INT,
                IN p_satuan VARCHAR(50),
                IN p_informasi TEXT,
                IN p_harga DOUBLE,
                IN p_min_order INT,
                IN p_gambar TEXT,
                IN p_created_at DATETIME,
                IN p_updated_at DATETIME,
                IN p_jumlah INT
            )
            BEGIN
                INSERT INTO aspal (
                    id, 
                    jenis_aspal, 
                    jangka_waktu_pemanasan, 
                    satuan, 
                    informasi, 
                    harga, 
                    min_order, 
                    gambar, 
                    created_at, 
                    updated_at
                ) VALUES (
                    p_id, 
                    p_jenis_aspal, 
                    p_jangka_waktu_pemanasan, 
                    p_satuan, 
                    p_informasi, 
                    p_harga, 
                    p_min_order, 
                    p_gambar, 
                    p_created_at, 
                    p_updated_at
                );

                INSERT INTO stok_aspal (
                    id, 
                    id_aspal, 
                    jumlah, 
                    tanggal, 
                    status
                ) VALUES (
                    p_id_stok_aspal, 
                    p_id, 
                    p_jumlah, 
                    p_created_at, 
                    1
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("
            DROP PROCEDURE IF EXISTS AddAspal;
        ");
    }
}