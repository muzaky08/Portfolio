<?php

namespace App\Models;

use CodeIgniter\Model;

class BiodataModel extends Model
{
    protected $table         = 'biodata';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'full_name',
        'job_title',
        'address',
        'email',
        'phone',
        'short_bio',
        'skills',
        'photo',
        'cv_path',
    ];
    protected $useTimestamps = true;

    public function getBiodata(): ?array
    {
        $profile = $this->first();
        if (! $profile) {
            return null;
        }

        if (isset($profile['skills']) && is_string($profile['skills'])) {
            $profile['skills'] = json_decode($profile['skills'], true) ?? [];
        }

        $profile['social_links'] = (new SocialLinkModel())->forBiodata((int) $profile['id']);

        return $profile;
    }

    public function getProfile(): ?array
    {
        return $this->getBiodata();
    }
}
