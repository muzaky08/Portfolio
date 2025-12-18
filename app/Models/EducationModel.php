<?php

namespace App\Models;

use CodeIgniter\Model;

class EducationModel extends Model
{
    protected $table         = 'educations';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'institution',
        'level',
        'major',
        'start_year',
        'end_year',
        'description',
        'logo',
        'sort_order',
    ];
    protected $useTimestamps = true;

    public function applyFilters(array $filters = []): self
    {
        if (! empty($filters['keyword'])) {
            $this->like('institution', $filters['keyword']);
        }

        if (! empty($filters['level'])) {
            $this->where('level', $filters['level']);
        }

        $direction = (! empty($filters['sort']) && strtolower($filters['sort']) === 'asc') ? 'ASC' : 'DESC';
        $this->orderBy('start_year', $direction);

        return $this;
    }
}
