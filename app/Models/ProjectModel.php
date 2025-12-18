<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table          = 'projects';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields  = [
        'title',
        'slug',
        'summary',
        'description',
        'technologies',
        'image',
        'project_url',
        'client',
        'completed_at',
        'is_featured',
    ];
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = 'deleted_at';

    public function featured(int $limit = 6): array
    {
        return $this->where('is_featured', 1)
            ->orderBy('completed_at', 'DESC')
            ->limit($limit)
            ->find();
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->first();
    }
}


