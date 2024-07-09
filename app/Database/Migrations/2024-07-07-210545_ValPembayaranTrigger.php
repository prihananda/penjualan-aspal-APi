<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ValPembayaranTrigger extends Migration
{
    public function up()
    {
        // Define the SQL statement to create the trigger
        $triggerSQL = "
            CREATE TRIGGER after_val_pembayaran_insert 
            AFTER INSERT ON val_pembayaran
            FOR EACH ROW 
            BEGIN
                DECLARE trans_id VARCHAR(255);
                DECLARE bayar_nominal DOUBLE;

                -- Get the transaction ID from the pembayaran table
                SELECT id_transaksi INTO trans_id 
                FROM pembayaran 
                WHERE id = NEW.id_pembayaran;

                -- Get the nominal payment from the pembayaran table
                SELECT nominal_bayar INTO bayar_nominal 
                FROM pembayaran 
                WHERE id = NEW.id_pembayaran;

                -- Update the total transaction amount in the transaksi table
                UPDATE transaksi 
                SET tot_transaksi = tot_transaksi + bayar_nominal 
                WHERE id = trans_id;
            END;
        ";

        // Execute the SQL statement
        $this->db->query($triggerSQL);
    }

    public function down()
    {
        // Define the SQL statement to drop the trigger
        $triggerSQL = "DROP TRIGGER IF EXISTS after_val_pembayaran_insert;";

        // Execute the SQL statement
        $this->db->query($triggerSQL);
    }
}