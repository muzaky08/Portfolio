<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminActivityLogModel extends Model
{
    protected $table         = 'admin_activity_logs';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'user_id',
        'user_name',
        'action',
        'description',
        'context',
        'ip_address',
        'user_agent',
        'created_at',
    ];
    protected $useTimestamps = false;

    public function applyFilters(array $filters = []): self
    {
        if (! empty($filters['keyword'])) {
            $this->groupStart()
                ->like('action', $filters['keyword'])
                ->orLike('description', $filters['keyword'])
                ->groupEnd();
        }

        if (! empty($filters['user_id'])) {
            $this->where('user_id', (int) $filters['user_id']);
        }

        if (! empty($filters['start_date'])) {
            $this->where('created_at >=', $filters['start_date'] . ' 00:00:00');
        }

        if (! empty($filters['end_date'])) {
            $this->where('created_at <=', $filters['end_date'] . ' 23:59:59');
        }

        return $this;
    }
}

