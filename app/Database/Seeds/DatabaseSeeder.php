<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $tables = [
            'users',
            'settings',
            'skills',
            'projects',
            'experiences',
            'activities',
            'educations',
            'social_links',
            'biodata',
        ];

        $this->db->disableForeignKeyChecks();
        foreach ($tables as $table) {
            $this->db->table($table)->truncate();
        }
        $this->db->enableForeignKeyChecks();

        $seeders = [
            UserSeeder::class,
            SettingSeeder::class,
            SkillSeeder::class,
            ProjectSeeder::class,
            ExperienceSeeder::class,
            ActivitySeeder::class,
            EducationSeeder::class,
            BiodataSeeder::class,
        ];

        foreach ($seeders as $seeder) {
            $this->call($seeder);
        }
    }
}
