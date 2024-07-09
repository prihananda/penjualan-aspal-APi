<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ValTransaksiProcedure extends Migration
{
    public function up()
    {
        $this->db->query("
           CREATE PROCEDURE AddValTransaksi(
                IN p_id VARCHAR(255),
                IN p_id_pengelola VARCHAR(255),
                IN p_id_transaksi VARCHAR(255),
                IN p_tgl_val DATETIME,
                IN p_daftar_kendaraan TEXT
            )
            BEGIN
                -- Insert into val_transaksi table
                INSERT INTO val_transaksi (id, id_pengelola, id_transaksi, tgl_val)
                VALUES (p_id, p_id_pengelola, p_id_transaksi, p_tgl_val);
                
                -- Update transaksi table
                UPDATE transaksi
                SET stat_transaksi = 1
                WHERE id = p_id_transaksi;
                
                -- Update detail_transaksi table
                UPDATE detail_transaksi
                SET daftar_kendaraan = p_daftar_kendaraan
                WHERE id_transaksi = p_id_transaksi;
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP PROCEDURE IF EXISTS AddValTransaksi");
    }
}