<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $skills = [
            ['name' => 'PHP & CodeIgniter', 'category' => 'Backend', 'level' => 92, 'description' => 'Membangun REST API dan aplikasi modular dengan CI4 dan Laravel.'],
            ['name' => 'JavaScript & Vue', 'category' => 'Frontend', 'level' => 85, 'description' => 'Menyusun komponen UI reaktif menggunakan Vue 3 dan Vite.'],
            ['name' => 'DevOps', 'category' => 'Ops', 'level' => 70, 'description' => 'CI/CD, Docker, dan monitoring stack untuk deployment yang stabil.'],
        ];

        $skills = array_map(function ($skill) use ($now) {
            return array_merge($skill, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $skills);

        $this->db->table('skills')->insertBatch($skills);
    }
}
