<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityModel extends Model
{
    protected $table         = 'activities';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'title',
        'description',
        'activity_date',
        'location',
        'category',
        'icon',
    ];
    protected $useTimestamps = true;

    public function applyFilters(array $filters = []): self
    {
        if (! empty($filters['keyword'])) {
            $this->groupStart()
                ->like('title', $filters['keyword'])
                ->orLike('description', $filters['keyword'])
                ->orLike('location', $filters['keyword'])
                ->groupEnd();
        }

        if (! empty($filters['category'])) {
            $categories = is_array($filters['category']) ? array_filter($filters['category']) : [$filters['category']];
            if (! empty($categories)) {
                $this->whereIn('category', $categories);
            }
        }

        if (! empty($filters['start_date'])) {
            $this->where('activity_date >=', $filters['start_date']);
        }

        if (! empty($filters['end_date'])) {
            $this->where('activity_date <=', $filters['end_date']);
        }

        if (! empty($filters['sort'])) {
            $direction = strtolower($filters['sort']) === 'asc' ? 'ASC' : 'DESC';
            $this->orderBy('activity_date', $direction);
        }

        return $this;
    }
}
