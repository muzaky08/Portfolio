<?php

namespace App\Models;

use CodeIgniter\Model;

class SkillModel extends Model
{
    protected $table          = 'skills';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ['name', 'category', 'level', 'description'];
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = 'deleted_at';

    public function categorized(): array
    {
        $skills  = $this->orderBy('category')->orderBy('level', 'DESC')->findAll();
        $grouped = [];
        foreach ($skills as $skill) {
            $category = $skill['category'] ?: 'General';
            $grouped[$category][] = $skill;
        }

        return $grouped;
    }
}

