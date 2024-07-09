<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'client';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = 'App\Entities\Client';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id',
        'nm_pembeli',
        'alamat',
        'no_tlp',
        'password'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'id' => 'is_unique[client.id]',
        'no_tlp' => 'is_unique[kendaraan.no_tlp]'
    ];
    protected $validationMessages = [
        'id' => [
            'is_unique' => 'id harus unik'
        ],
        'no_tlp' => [
            'is_unique' => 'no_tlp harus unik'
        ],
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function getUserByNoTlp($no_tlp)
    {
        return $this->where('no_tlp', $no_tlp)->first();
    }
}