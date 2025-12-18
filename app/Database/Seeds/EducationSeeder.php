<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EducationSeeder extends Seeder
{
    public function run()
    {
        $educations = [
            [
                'institution' => 'SDN Melati 01',
                'level'       => 'SD',
                'major'       => null,
                'start_year'  => 2002,
                'end_year'    => 2008,
                'description' => 'Aktif di klub sains dan juara lomba cerdas cermat tingkat kota.',
                'logo'        => null,
                'sort_order'  => 1,
            ],
            [
                'institution' => 'SMP Negeri 2 Bandung',
                'level'       => 'SMP',
                'major'       => null,
                'start_year'  => 2008,
                'end_year'    => 2011,
                'description' => 'Ketua ekstrakurikuler komputer dan finalis Olimpiade Matematika.',
                'logo'        => null,
                'sort_order'  => 2,
            ],
            [
                'institution' => 'SMA Negeri 5 Bandung',
                'level'       => 'SMA',
                'major'       => 'IPA',
                'start_year'  => 2011,
                'end_year'    => 2014,
                'description' => 'Membangun portal informasi sekolah dan menjadi ketua tim research.',
                'logo'        => null,
                'sort_order'  => 3,
            ],
            [
                'institution' => 'Institut Teknologi Bandung',
                'level'       => 'Kuliah',
                'major'       => 'Teknik Informatika',
                'start_year'  => 2014,
                'end_year'    => 2018,
                'description' => 'Asisten riset di lab data, skripsi mengenai arsitektur microservices.',
                'logo'        => null,
                'sort_order'  => 4,
            ],
        ];

        $now = date('Y-m-d H:i:s');
        $educations = array_map(static function ($education) use ($now) {
            return array_merge($education, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $educations);

        $this->db->table('educations')->insertBatch($educations);
    }
}
