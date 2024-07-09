<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Aspal extends ResourceController
{
    protected $modelName = 'App\Models\AspalModel';
    protected $format = 'json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     * 
     * 
     */

    public function getAspalWithStock()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('aspal');

        $sql = "
                       SELECT 
    a.id,
    a.jenis_aspal,
    a.jangka_waktu_pemanasan,
    a.satuan,
    a.informasi,
    a.harga,
    a.min_order,
    a.gambar,
    a.created_at,
    a.updated_at,
    COALESCE(SUM(CASE 
        WHEN s.status = 1 THEN s.jumlah 
        WHEN s.status = 0 THEN -s.jumlah 
        ELSE 0 
    END), 0) AS stok
FROM 
    aspal a
LEFT JOIN 
    stok_aspal s ON a.id = s.id_aspal
GROUP BY 
    a.id,
    a.jenis_aspal,
    a.jangka_waktu_pemanasan,
    a.satuan,
    a.informasi,
    a.harga,
    a.min_order,
    a.gambar,
    a.created_at,
    a.updated_at;
         ";

        $query = $db->query($sql);
        $results = $query->getResult();

        return $this->respond($results);
    }

    public function getAspalWithStockById($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('aspal');

        $sql = "
            SELECT 
    a.id,
    a.jenis_aspal,
    a.jangka_waktu_pemanasan,
    a.satuan,
    a.informasi,
    a.harga,
    a.min_order,
    a.gambar,
    a.created_at,
    a.updated_at,
    COALESCE(SUM(CASE 
        WHEN s.status = 1 THEN s.jumlah 
        WHEN s.status = 0 THEN -s.jumlah 
        ELSE 0 
    END), 0) AS stok
FROM 
    aspal a
LEFT JOIN 
    stok_aspal s ON a.id = s.id_aspal
WHERE 
    a.id = ?
GROUP BY 
    a.id,
    a.jenis_aspal,
    a.jangka_waktu_pemanasan,
    a.satuan,
    a.informasi,
    a.harga,
    a.min_order,
    a.gambar,
    a.created_at,
    a.updated_at;
        ";

        $query = $db->query($sql, [$id]);
        $result = $query->getRow(); // Fetch a single row

        if ($result) {
            return $this->respond($result);
        } else {
            return $this->failNotFound('Aspal tidak ditemukan id: ' . $id);
        }
    }



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
            return $this->fail('Data tidak ditemukan');
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

        $db = \Config\Database::connect();
        $builder = $db->table('aspal');

        // Use a prepared statement to call the stored procedure
        $sql = "CALL AddAspal(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $db->query($sql, [
            $data['id'],
            $data['id_stok_aspal'],
            $data['jenis_aspal'],
            $data['jangka_waktu_pemanasan'],
            $data['satuan'],
            $data['informasi'],
            $data['harga'],
            $data['min_order'],
            $data['gambar'],
            $data['created_at'],
            $data['updated_at'],
            $data['jumlah'],
        ]);

        return $this->respond(['message' => 'Data created successfully.']);
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
            $aspal = new \App\Entities\Aspal();
            $aspal->fill($data);

            if ($this->model->save($aspal)) {
                return $this->respondUpdated(($data));
            }
            throw new \Exception();

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