<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class StokAspal extends ResourceController
{
    protected $modelName = 'App\Models\StokAspalModel';
    protected $format = 'json';
    public function getStokAspalWithJenisAspal()
    {
        // Connect to the database
        $db = \Config\Database::connect();

        // Build the query to join the tables and select the fields
        $builder = $db->table('stok_aspal');
        $builder->select('stok_aspal.*, aspal.jenis_aspal, aspal.satuan');
        $builder->join('aspal', 'aspal.id = stok_aspal.id_aspal');

        // Execute the query and get the result
        $query = $builder->get();
        $result = $query->getResult();

        // Return the result as a JSON response
        if ($result) {
            return $this->respond($result);
        } else {
            return $this->failNotFound('No data found');
        }
    }

    public function getStokAspalWithJenisAspalById($id = null)
    {

        if (is_null($id)) {
            return $this->fail('ID is required');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('stok_aspal');
        $builder->select('stok_aspal.*, aspal.jenis_aspal, aspal.satuan');
        $builder->join('aspal', 'aspal.id = stok_aspal.id_aspal');
        $builder->where('stok_aspal.id', $id);
        $query = $builder->get();
        $result = $query->getRow();

        if ($result) {
            return $this->respond($result);
        } else {
            return $this->failNotFound('Data not found');
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
        $stok_aspal = new \App\Entities\StokAspal();
        $stok_aspal->fill($data);
        if ($this->model->save($stok_aspal)) {
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
            $stok_aspal = new \App\Entities\StokAspal();
            $stok_aspal->fill($data);

            if ($this->model->save($stok_aspal)) {
                return $this->respondUpdated(($data));
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