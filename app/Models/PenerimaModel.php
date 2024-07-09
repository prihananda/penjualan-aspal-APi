<?php

namespace App\Models;

use CodeIgniter\Model;

class PenerimaModel extends Model
{
    protected $table = 'penerima';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = 'App\Entities\Penerima';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id',
        'id_transaksi',
        'nm_penerima',
        'alamat',
        'no_telp'
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
        'id' => 'is_unique[penerima.id]'
    ];
    protected $validationMessages = [
        'id' => [
            'unique' => 'id harus unik'
        ]
    ];
    protected $skipValidation = true;
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
}