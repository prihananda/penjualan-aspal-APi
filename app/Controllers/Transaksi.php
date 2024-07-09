<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Transaksi extends ResourceController
{
    protected $modelName = 'App\Models\TransaksiModel';
    protected $format = 'json';

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $data = $this->model->findAll();
        ;
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return $this->fail("Data tidak ditemukan");
        }
        return $this->respond($data);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        // Get data from POST request
        $data = $this->request->getPost();

        // Validate required fields
        $requiredFields = [
            'id_transaksi',
            'id_client',
            'tgl_transaksi',
            'stat_pembayaran',
            'stat_transaksi',
            'stat_pengiriman',
            'tot_transaksi',
            'tot_tagihan',
            'id_detail_transaksi',
            'id_aspal',
            'jml_pesanan'
        ];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                return $this->fail("Required field '{$field}' is missing");
            }
        }

        // Prepare parameters for the stored procedure
        $params = [
            $data['id_transaksi'],
            $data['id_client'],
            $data['tgl_transaksi'],
            $data['stat_pembayaran'],
            $data['stat_transaksi'],
            $data['stat_pengiriman'],
            $data['tot_transaksi'],
            $data['tot_tagihan'],
            $data['id_detail_transaksi'],
            $data['id_aspal'],
            $data['jml_pesanan']
        ];

        try {
            // Call the stored procedure using CodeIgniter's database connection
            $db = \Config\Database::connect();

            // Prepare the statement
            $sql = "CALL CreateTransaction(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Execute the query
            $query = $db->query($sql, $params);

            // Handle success or failure based on procedure execution
            if ($query) {
                return $this->respondCreated($data); // Return success response
            } else {
                return $this->fail('Failed to execute stored procedure'); // Return failure response
            }
        } catch (\Exception $e) {
            return $this->fail($e->getMessage()); // Return detailed error message
        }
    }


    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        try {
            $data = $this->request->getRawInput();
            $data['id'] = $id;
            if (!$this->model->find($id)) {
                return $this->fail('Data tidak ditemukan');
            }
            $transaksi = new \App\Entities\Transaksi();
            $transaksi->fill($data);

            if ($this->model->save($transaksi)) {
                return $this->respondUpdated($data);
            }
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }
        if ($this->model->delete($id)) {
            return $this->respondDeleted("Data dengan id " . $id . " berhasil dihapus");
        }
        return $this->fail("Error");
    }

    /**
     * Custom method to get Aspal details with Stok and Kendaraan
     *
     * @return ResponseInterface
     */
    public function getAspalCatalgoue()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('aspal');
        $builder->select('
            aspal.*,
            stok_aspal.jumlah,
            kendaraan.maks_cap,
            aspal.jenis_aspal,
            aspal.satuan
        ');
        $builder->join('stok_aspal', 'stok_aspal.id_aspal = aspal.id', 'left');
        $builder->join('kendaraan', 'kendaraan.id_aspal = aspal.id', 'left');

        $query = $builder->get();
        $result = $query->getResult();

        return $this->respond($result);
    }
}