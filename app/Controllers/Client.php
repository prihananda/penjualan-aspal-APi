<?php

namespace App\Controllers;

use App\Models\ClientModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Client extends ResourceController
{
    protected $modelName = 'App\Models\ClientModel';
    protected $format = 'json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function signup()
    {
        helper(['form']);
        $data = $this->request->getPost();
        $client = new \App\Entities\Client();
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $client->fill($data);
        if ($this->model->save($client)) {
            $session = session();
            $sessionData = [
                'id' => $client->id,
                'nm_pembeli' => $client->nm_pembeli,
                'alamat' => $client->alamat,
                'no_tlp' => $client->no_tlp,
                'password' => '',
                'logged_in' => true

            ];
            $session->set($sessionData);
            return $this->response->setStatusCode(201)->setJSON([
                'status' => true,
                'message' => 'Login successful',
                'user' => $sessionData
            ]);
        }
        return $this->fail("Error");
    }

    public function login()
    {
        helper(['form']);

        // Validation rules
        $rules = [
            'no_tlp' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'message' => $this->validator->getErrors()
            ]);
        }

        $no_tlp = $this->request->getVar('no_tlp');
        $password = $this->request->getVar('password');

        $clientModel = new ClientModel();
        $client = $clientModel->getUserByNoTlp($no_tlp);

        if (!$client || !password_verify($password, $client->password)) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => false,
                'message' => 'Invalid no_tlp or password'
            ]);
        }

        // Set session data
        $session = session();
        $sessionData = [
            'id' => $client->id,
            'nm_pembeli' => $client->nm_pembeli,
            'alamat' => $client->alamat,
            'no_tlp' => $client->no_tlp,
            'password' => '',
            'logged_in' => true,
        ];
        $session->set($sessionData);

        return $this->response->setStatusCode(200)->setJSON([
            'status' => true,
            'message' => 'Login successful',
            'user' => $sessionData
        ]);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();

        return $this->response->setStatusCode(200)->setJSON([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
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
        $client = new \App\Entities\Client();
        $client->fill($data);
        if ($this->model->save($client)) {

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
            $client = new \App\Entities\Client();
            $client->fill($data);

            if ($this->model->save($client)) {
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