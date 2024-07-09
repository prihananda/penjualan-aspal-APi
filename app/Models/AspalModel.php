<?php

namespace App\Models;

use CodeIgniter\Model;

class AspalModel extends Model
{
    protected $table = 'aspal';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = 'App\Entities\Aspal';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id',
        'jenis_aspal',
        'jangka_waktu_pemanasan',
        'satuan',
        'informasi',
        'harga',
        'min_order',
        'gambar',
        'created_at',
        'updated_at'
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
        'id' => 'required|is_unique[aspal.id]',
    ];

    protected $updateValidationRules = [
        
    ];

    protected $updateValidationMessages = [
        
    ];

    protected $validationMessages = [
        'id' => [
            'required' => 'silahkan masukan id',
            'is_unique' => 'id harus unik'
        ],

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