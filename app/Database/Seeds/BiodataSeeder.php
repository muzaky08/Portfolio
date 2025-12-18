<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BiodataSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $biodata = [
            'full_name'  => 'Ahmad Zaky Pratama',
            'job_title'  => 'Lead Software Engineer',
            'address'    => 'Bandung, Indonesia',
            'email'      => 'zaky@example.com',
            'phone'      => '+62 812 9000 1234',
            'short_bio'  => 'Menyusun solusi digital lintas industri dengan fokus pada performa dan pengalaman pengguna. Terbiasa memimpin tim lintas disiplin dan memvalidasi eksperimen produk.',
            'skills'     => json_encode([
                ['label' => 'Solution Architecture', 'level' => 90],
                ['label' => 'Product Management', 'level' => 75],
                ['label' => 'People Mentoring', 'level' => 80],
            ]),
            'photo'      => 'https://via.placeholder.com/360x360.png?text=Profile',
            'cv_path'    => 'assets/docs/cv.pdf',
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $this->db->table('biodata')->insert($biodata);
        $biodataId = $this->db->insertID();

        $links = [
            ['label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/yourprofile', 'icon' => 'bi-linkedin'],
            ['label' => 'GitHub', 'url' => 'https://github.com/yourusername', 'icon' => 'bi-github'],
            ['label' => 'Twitter', 'url' => 'https://twitter.com/yourhandle', 'icon' => 'bi-twitter'],
        ];

        $batch = [];
        foreach ($links as $index => $link) {
            $batch[] = [
                'biodata_id' => $biodataId,
                'label'      => $link['label'],
                'url'        => $link['url'],
                'icon'       => $link['icon'],
                'sort_order' => $index,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        $this->db->table('social_links')->insertBatch($batch);
    }
}
