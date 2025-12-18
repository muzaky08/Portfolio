<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialLinkModel extends Model
{
    protected $table         = 'social_links';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'biodata_id',
        'label',
        'url',
        'icon',
        'sort_order',
    ];
    protected $useTimestamps = true;

    public function forBiodata(int $biodataId): array
    {
        return $this->where('biodata_id', $biodataId)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    public function replaceLinks(int $biodataId, array $links): void
    {
        $this->where('biodata_id', $biodataId)->delete();
        if (empty($links)) {
            return;
        }

        $batch = [];
        foreach ($links as $index => $link) {
            $batch[] = [
                'biodata_id' => $biodataId,
                'label'      => $link['label'],
                'url'        => $link['url'],
                'icon'       => $link['icon'] ?? 'bi-link-45deg',
                'sort_order' => $link['sort_order'] ?? $index,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->insertBatch($batch);
    }
}

