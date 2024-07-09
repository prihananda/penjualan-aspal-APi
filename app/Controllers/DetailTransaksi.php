<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class DetailTransaksi extends ResourceController
{
    protected $modelName = 'App\Models\DetailTransaksiModel';
    protected $format = 'json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('detail_transaksi');
        $builder->select('
            detail_transaksi.id,
            detail_transaksi.id_transaksi,
            detail_transaksi.id_aspal,
            aspal.jenis_aspal,
            aspal.satuan,
            detail_transaksi.jml_pesanan,
            client.nm_pembeli,
            client.alamat,
            detail_transaksi.daftar_kendaraan,
            transaksi.stat_pembayaran,
            transaksi.stat_transaksi,
            transaksi.stat_pengiriman,
            transaksi.tot_transaksi,
            transaksi.tot_tagihan
        ');
        $builder->join('aspal', 'aspal.id = detail_transaksi.id_aspal');
        $builder->join('transaksi', 'transaksi.id = detail_transaksi.id_transaksi');
        $builder->join('client', 'client.id = transaksi.id_client');

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

        $builder = $db->table('detail_transaksi');
        $builder->select('
            detail_transaksi.id,
            detail_transaksi.id_transaksi,
            detail_transaksi.id_aspal,
            aspal.jenis_aspal,
            aspal.satuan,
            detail_transaksi.jml_pesanan,
            client.nm_pembeli,
            client.alamat,
            detail_transaksi.daftar_kendaraan,
            transaksi.stat_pembayaran,
            transaksi.stat_transaksi,
            transaksi.stat_pengiriman,
            transaksi.tot_transaksi,
            transaksi.tot_tagihan
        ');
        $builder->join('aspal', 'aspal.id = detail_transaksi.id_aspal');
        $builder->join('transaksi', 'transaksi.id = detail_transaksi.id_transaksi');
        $builder->join('client', 'client.id = transaksi.id_client');
        $builder->where('detail_transaksi.id', $id);

        $query = $builder->get();
        $result = $query->getRow();

        if ($result) {
            return $this->respond($result);
        } else {
            return $this->failNotFound('Data not found');
        }
    }

    public function getByClientId($id = null)
    {
        if (!$id) {
            return $this->fail('ID is required');
        }

        $db = \Config\Database::connect();

        $builder = $db->table('detail_transaksi');
        $builder->select('
            detail_transaksi.id,
            detail_transaksi.id_transaksi,
            detail_transaksi.id_aspal,
            aspal.jenis_aspal,
            aspal.satuan,
            detail_transaksi.jml_pesanan,
            client.nm_pembeli,
            client.alamat,
            detail_transaksi.daftar_kendaraan,
            transaksi.stat_pembayaran,
            transaksi.stat_transaksi,
            transaksi.stat_pengiriman,
            transaksi.tot_transaksi,
            transaksi.tot_tagihan
        ');
        $builder->join('aspal', 'aspal.id = detail_transaksi.id_aspal');
        $builder->join('transaksi', 'transaksi.id = detail_transaksi.id_transaksi');
        $builder->join('client', 'client.id = transaksi.id_client');
        $builder->where('transaksi.id_client', $id);

        $query = $builder->get();
        $result = $query->getResult();

        if ($result) {
            return $this->respond($result);
        } else {
            return $this->failNotFound('Belum ada data');
        }
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $data = $this->request->getPost();
        $detail_transaksi = new \App\Entities\DetailTransaksi();
        $detail_transaksi->fill($data);
        if (!$this->validate($this->model->valiationRules, $this->model->validationMessages)) {
            return $this->fail($this->validator->getErrors());
        }
        if ($this->model->save($detail_transaksi)) {
            return $this->respondCreated($data);
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
            $detail_transaksi = new \App\Entities\DetailTransaksi();
            $detail_transaksi->fill($data);

            if (!$this->validate($this->model->updateValidationRules, $this->model->validationMessages)) {
                return $this->fail($this->validator->getErrors());
            }
            if ($this->model->save($detail_transaksi)) {
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