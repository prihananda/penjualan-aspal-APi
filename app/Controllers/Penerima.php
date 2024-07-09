<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Penerima extends ResourceController
{
    protected $modelName = 'App\Models\PenerimaModel';
    protected $format = 'json';

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('penerima');
        $builder->select('
            penerima.*,
            transaksi.tgl_transaksi
        ');
        $builder->join('transaksi', 'transaksi.id = penerima.id_transaksi');

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

        $builder = $db->table('penerima');
        $builder->select('
            penerima.*,
            transaksi.*
        ');
        $builder->join('transaksi', 'transaksi.id = penerima.id_transaksi');
        $builder->where('penerima.id', $id);

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
        $data = $this->request->getPost();
        $penerima = new \App\Entities\Penerima();
        $penerima->fill($data);
        if ($this->model->save($penerima)) {
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
            $penerima = new \App\Entities\Penerima();
            $penerima->fill($data);

            if ($this->model->save($penerima)) {
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