<?php

namespace App\Models;

use CodeIgniter\Model;

class ExperienceModel extends Model
{
    protected $table          = 'experiences';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields  = [
        'role',
        'company',
        'location',
        'start_date',
        'end_date',
        'is_current',
        'description',
    ];
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = 'deleted_at';

    public function ordered(): array
    {
        return $this->orderBy('start_date', 'DESC')->findAll();
    }
}


