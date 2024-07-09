<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;

class ValTransaksi extends ResourceController
{
    protected $modelName = 'App\Models\ValTransaksiModel';
    protected $format = 'json';

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('val_transaksi');
        $builder->select('
            val_transaksi.*,
            transaksi.*,
            pengelola.nm_pengelola
        ');
        $builder->join('transaksi', 'transaksi.id = val_transaksi.id_transaksi');
        $builder->join('pengelola', 'pengelola.id = val_transaksi.id_pengelola');

        $query = $builder->get();
        $result = $query->getResult();

        return $this->respond($result);
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
        if (!$id) {
            return $this->fail('ID is required');
        }

        $db = \Config\Database::connect();

        $builder = $db->table('val_transaksi');
        $builder->select('
            val_transaksi.*,
            transaksi.*,
            pengelola.nm_pengelola
        ');
        $builder->join('transaksi', 'transaksi.id = val_transaksi.id_transaksi');
        $builder->join('pengelola', 'pengelola.id = val_transaksi.id_pengelola');
        $builder->where('val_transaksi.id', $id);

        $query = $builder->get();
        $result = $query->getRow();

        if ($result) {
            return $this->respond($result);
        } else {
            return $this->failNotFound('Data not found');
        }
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
            'id',                // val_transaksi ID
            'id_pengelola',
            'id_transaksi',
            'tgl_val',
            'daftar_kendaraan',  // new_id_stok_aspal parameter
        ];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                return $this->fail("Required field '{$field}' is missing");
            }
        }

        // Prepare parameters for the stored procedure
        $params = [
            $data['id'],                   // in_val_transaksi_id
            $data['id_pengelola'],         // in_val_transaksi_id_transaksi
            $data['id_transaksi'],             // in_id_aspal
            $data['tgl_val'],  // in_id_detail_transaksi
            $data['daftar_kendaraan'],              // in_tanggal       // in_id_pengelola
        ];

        try {
            // Call the stored procedure using CodeIgniter's database connection
            $db = \Config\Database::connect();

            // Prepare the statement
            $sql = "CALL AddValTransaksi(?, ?, ?, ?, ?)";

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
     * Custom method to add data using a stored procedure
     */

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {

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
            $val_transaksi = new \App\Entities\ValTransaksi();
            $val_transaksi->fill($data);

            if ($this->model->save($val_transaksi)) {
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
}