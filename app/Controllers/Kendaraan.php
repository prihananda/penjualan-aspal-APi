<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Kendaraan extends ResourceController
{
    protected $modelName = 'App\Models\KendaraanModel';
    protected $format = 'json';
    public function getKendaraanWithJenisAspal()
    {
        // Get the database connection
        $db = \Config\Database::connect();

        // Initialize the query builder
        $builder = $db->table('kendaraan');

        // Select all fields from kendaraan and the jenis_aspal field from aspal
        $builder->select('kendaraan.*, aspal.jenis_aspal');

        // Perform the join
        $builder->join('aspal', 'aspal.id = kendaraan.id_aspal');

        // Execute the query
        $query = $builder->get();

        // Fetch the results
        $result = $query->getResult();

        // Check if there is data returned
        if ($result) {
            return $this->respond($result);
        } else {
            return $this->failNotFound('Data tidak ditemukan');
        }
    }

    public function getKendaraanWithJenisAspalById($id = null)
    {
        if (is_null($id)) {
            return $this->fail('ID is required');
        }

        // Get the database connection
        $db = \Config\Database::connect();

        // Initialize the query builder
        $builder = $db->table('kendaraan');

        // Select all fields from kendaraan and the jenis_aspal field from aspal
        $builder->select('kendaraan.*, aspal.jenis_aspal');

        // Perform the join
        $builder->join('aspal', 'aspal.id = kendaraan.id_aspal');

        // Add the where clause
        $builder->where('kendaraan.id', $id);

        // Execute the query
        $query = $builder->get();

        // Fetch the single row
        $result = $query->getRow();

        // Check if there is data returned
        if ($result) {
            return $this->respond($result);
        } else {
            return $this->failNotFound('Data tidak ditemukan');
        }
    }
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        return $this->respond($this->model->findAll());
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
        if (!$this->model->find($id)) {
            return $this->fail("Data tidak ditemukan");
        }
        return $this->respond($this->model->find($id));
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
        $data = $this->request->getPost();
        $kendaraan = new \App\Entities\Kendaraan();
        $kendaraan->fill($data);
        if ($this->model->save($kendaraan)) {
            return $this->respondCreated(($data));
        }
        return $this->fail("Error");
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
            $kendaraan = new \App\Entities\Kendaraan();
            $kendaraan->fill($data);

            if ($this->model->save($kendaraan)) {
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