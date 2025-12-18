<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table         = 'settings';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['key', 'value', 'type', 'section'];
    protected $useTimestamps = true;

    public function getPairs(?string $section = null): array
    {
        $builder = $this->builder();
        if ($section) {
            $builder->where('section', $section);
        }

        $settings = $builder->get()->getResultArray();
        $result   = [];

        foreach ($settings as $setting) {
            $result[$setting['key']] = $setting['value'];
        }

        return $result;
    }

    public function findValue(string $key, $default = null)
    {
        $setting = $this->builder()->where('key', $key)->get()->getRowArray();

        return $setting['value'] ?? $default;
    }

    public function sync(array $payload, string $section): void
    {
        foreach ($payload as $key => $value) {
            $existing = $this->builder()->where('key', $key)->get()->getRowArray();
            $fieldValue = is_array($value) ? ($value['value'] ?? null) : $value;
            $fieldType  = is_array($value) ? ($value['type'] ?? 'text') : 'text';
            $data = [
                'key'     => $key,
                'value'   => $fieldValue,
                'section' => $section,
                'type'    => $existing['type'] ?? $fieldType,
            ];

            if ($existing) {
                $this->update($existing['id'], $data);
            } else {
                $this->insert($data);
            }
        }
    }
}

