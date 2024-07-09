<?php

namespace App\Controllers;

use App\Models\PengelolaModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Pengelola extends ResourceController
{
    protected $modelName = 'App\Models\PengelolaModel'; // Ensure this matches your actual model class name
    protected $format = 'json';

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function login()
    {
        helper(['form']);

        // Validation rules
        $rules = [
            'id' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'message' => $this->validator->getErrors()
            ]);
        }

        $id = $this->request->getVar('id');
        $password = $this->request->getVar('password');

        $pengelolaModel = new PengelolaModel();
        $pengelola = $pengelolaModel->getPengelolaById($id);

        if (!$pengelola || !password_verify($password, $pengelola->password)) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => false,
                'message' => 'Invalid id or password'
            ]);
        }

        // Set session data
        $session = session();
        $sessionData = [
            'id' => $pengelola->id,
            'nm_pengelola' => $pengelola->nm_pengelola,
            'username' => $pengelola->username,
            'password' => '',
            'role' => $pengelola->role,
            'logged_in' => true,
        ];
        $session->set($sessionData);

        return $this->response->setStatusCode(200)->setJSON([
            'status' => true,
            'message' => 'Login successful',
            'pengelola' => $sessionData
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
        $data = $this->model->findAll();
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
            return $this->fail('Data tidak ditemukan');
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
        // Typically not used in RESTful APIs
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $data = $this->request->getPost();

        // Hash the password directly
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // Create new Pengelola entity
        $pengelola = new \App\Entities\Pengelola();
        $pengelola->fill($data);

        // Save and respond
        if ($this->model->save($pengelola)) {
            return $this->respondCreated($data);
        }
        return $this->fail("Error occurred while creating data.");
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
        // Typically not used in RESTful APIs
    }

    /**
     * Update the designated resource object from the "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id'] = $id;

        // Check if the record exists
        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }

        // Hash the password if it is set
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // Create Pengelola entity
        $pengelola = new \App\Entities\Pengelola();
        $pengelola->fill($data);

        // Save and respond
        if ($this->model->save($pengelola)) {
            return $this->respondUpdated($data);
        }
        return $this->fail("Error occurred while updating data.");
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
        // Check if the record exists
        if (!$this->model->find($id)) {
            return $this->fail('Data tidak ditemukan');
        }

        // Delete and respond
        if ($this->model->delete($id)) {
            return $this->respondDeleted("Data with id $id successfully deleted.");
        }
        return $this->fail("Error occurred while deleting data.");
    }
}