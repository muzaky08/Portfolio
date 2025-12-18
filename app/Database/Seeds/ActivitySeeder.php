<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run()
    {
        $activities = [
            [
                'title'         => 'Mentoring Mahasiswa Capstone',
                'description'   => 'Membantu tim kampus menilai solusi IoT dan memberikan masukan arsitektur.',
                'activity_date' => date('Y-m-d', strtotime('-1 day')),
                'location'      => 'Bandung',
                'category'      => 'kuliah',
                'icon'          => 'bi-mortarboard',
            ],
            [
                'title'         => 'Standup Sprint Project Orion',
                'description'   => 'Daily sync bersama tim backend & devops untuk memastikan feature toggle siap.',
                'activity_date' => date('Y-m-d'),
                'location'      => 'Remote',
                'category'      => 'kerja',
                'icon'          => 'bi-briefcase',
            ],
            [
                'title'         => 'Latihan Lari 5K',
                'description'   => 'Pemanasan menjelang event komunitas lari minggu depan.',
                'activity_date' => date('Y-m-d', strtotime('-2 days')),
                'location'      => 'GBK Senayan',
                'category'      => 'lainnya',
                'icon'          => 'bi-activity',
            ],
        ];

        $now = date('Y-m-d H:i:s');
        $activities = array_map(static function ($activity) use ($now) {
            return array_merge($activity, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $activities);

        $this->db->table('activities')->insertBatch($activities);
    }
}
