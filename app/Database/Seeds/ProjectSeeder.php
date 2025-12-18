<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $projects = [
            [
                'title'        => 'SaaS Analytics Dashboard',
                'slug'         => 'saas-analytics-dashboard',
                'summary'      => 'Platform laporan realtime untuk produk SaaS B2B.',
                'description'  => 'Menghadirkan insight bisnis dengan multi-tenant architecture, charts interaktif, dan integrasi billing.',
                'technologies' => 'CodeIgniter 4, Alpine.js, MySQL, Redis',
                'project_url'  => 'https://example.com/saas',
                'client'       => 'TechNova',
                'is_featured'  => 1,
            ],
            [
                'title'        => 'Marketplace UMKM',
                'slug'         => 'marketplace-umkm',
                'summary'      => 'Marketplace untuk mempromosikan produk lokal Indonesia.',
                'description'  => 'Payment gateway terintegrasi, katalog dinamis, dan modul promosi otomatis.',
                'technologies' => 'CodeIgniter 4, Bootstrap 5, Midtrans API',
                'project_url'  => 'https://example.com/umkm',
                'client'       => 'Kemenkop',
                'is_featured'  => 0,
            ],
            [
                'title'        => 'Company Profile Interactive',
                'slug'         => 'company-profile-interactive',
                'summary'      => 'Website company profile dengan storytelling interaktif.',
                'description'  => 'Menggabungkan animasi ringan dengan CMS sehingga tim marketing bisa update konten secara mandiri.',
                'technologies' => 'CodeIgniter 4, Tailwind, GSAP',
                'project_url'  => 'https://example.com/company',
                'client'       => 'Inovasi Corp',
                'is_featured'  => 1,
            ],
        ];

        $projects = array_map(function ($project) use ($now) {
            $project['created_at'] = $now;
            $project['updated_at'] = $now;
            $project['completed_at'] = date('Y-m-d');
            return $project;
        }, $projects);

        $this->db->table('projects')->insertBatch($projects);
    }
}
