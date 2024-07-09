<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionProcedure extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE PROCEDURE CreateTransaction(
                IN in_id_transaksi VARCHAR(36),
                IN in_id_client VARCHAR(36),
                IN in_tgl_transaksi DATE,
                IN in_stat_pembayaran INT,
                IN in_stat_transaksi INT,
                IN in_stat_pengiriman INT,
                IN in_tot_transaksi DOUBLE,
                IN in_tot_tagihan DOUBLE,
                IN in_id_detail_transaksi VARCHAR(36),
                IN in_id_aspal VARCHAR(36),
                IN in_jml_pesanan DOUBLE
            )
            BEGIN
                -- Insert into transaksi
                INSERT INTO transaksi (
                    id,
                    id_client,
                    tgl_transaksi,
                    stat_pembayaran,
                    stat_transaksi,
                    stat_pengiriman,
                    tot_transaksi,
                    tot_tagihan
                ) VALUES (
                    in_id_transaksi,
                    in_id_client,
                    in_tgl_transaksi,
                    in_stat_pembayaran,
                    in_stat_transaksi,
                    in_stat_pengiriman,
                    in_tot_transaksi,
                    in_tot_tagihan
                );

                -- Insert into detail_transaksi
                INSERT INTO detail_transaksi (
                    id,
                    id_transaksi,
                    id_aspal,
                    jml_pesanan
                ) VALUES (
                    in_id_detail_transaksi,
                    in_id_transaksi, -- Use the same id_transaksi
                    in_id_aspal,
                    in_jml_pesanan
                );
            END;
        ");
    }

    public function down()
    {
        $this->db->query("DROP PROCEDURE IF EXISTS CreateTransaction");
    }
}