<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PenerimaTrigger extends Migration
{
    public function up()
    {
        // SQL query to create the trigger
        $sql = "
            CREATE TRIGGER update_transaksi_after_insert_penerima
            AFTER INSERT ON penerima
            FOR EACH ROW
            BEGIN
                UPDATE transaksi
                SET stat_pengiriman = 2
                WHERE id = NEW.id_transaksi;
            END;
        ";

        // Execute the SQL query
        $this->db->query($sql);
    }

    public function down()
    {
        // SQL query to drop the trigger
        $sql = "DROP TRIGGER IF EXISTS update_transaksi_after_insert_penerima;";

        // Execute the SQL query
        $this->db->query($sql);
    }
}