<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $experiences = [
            [
                'role'        => 'Lead Software Engineer',
                'company'     => 'Inovasi Digital',
                'location'    => 'Jakarta',
                'start_date'  => '2022-01-01',
                'end_date'    => null,
                'is_current'  => 1,
                'description' => 'Memimpin squad pengembangan produk SaaS, mentoring engineer, dan memastikan kualitas release.',
            ],
            [
                'role'        => 'Senior Web Developer',
                'company'     => 'Startup Labs',
                'location'    => 'Bandung',
                'start_date'  => '2019-06-01',
                'end_date'    => '2021-12-31',
                'is_current'  => 0,
                'description' => 'Membangun aplikasi e-commerce dan kampanye marketing dengan integrasi 3rd-party.',
            ],
        ];

        $experiences = array_map(function ($experience) use ($now) {
            $experience['created_at'] = $now;
            $experience['updated_at'] = $now;
            return $experience;
        }, $experiences);

        $this->db->table('experiences')->insertBatch($experiences);
    }
}
