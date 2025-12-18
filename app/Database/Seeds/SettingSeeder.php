<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $settings = [
            [
                'key'       => 'hero_headline',
                'value'     => 'Halo, saya Zaky.',
                'type'      => 'text',
                'section'   => 'hero',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'       => 'hero_headline_en',
                'value'     => 'Hello, I’m Zaky.',
                'type'      => 'text',
                'section'   => 'hero',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'     => 'hero_subheadline',
                'value'   => 'Full-stack web developer yang fokus pada pengalaman pengguna.',
                'type'    => 'text',
                'section' => 'hero',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'     => 'hero_subheadline_en',
                'value'   => 'Full-stack web developer focused on delightful experiences.',
                'type'    => 'text',
                'section' => 'hero',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'     => 'hero_cta_text',
                'value'   => 'Lihat Portofolio',
                'type'    => 'text',
                'section' => 'hero',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'     => 'hero_cta_link',
                'value'   => '#projects',
                'type'    => 'url',
                'section' => 'hero',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'     => 'about_summary',
                'value'   => 'Lebih dari 6 tahun membangun aplikasi web modern untuk startup dan enterprise.',
                'type'    => 'text',
                'section' => 'about',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'     => 'about_summary_en',
                'value'   => 'Over six years building modern web apps for startups and enterprises.',
                'type'    => 'text',
                'section' => 'about',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'     => 'about_description',
                'value'   => 'Saya menggabungkan analisis bisnis dan craft engineering untuk menghadirkan solusi digital yang berdampak. Saat ini fokus pada PHP, JavaScript, dan cloud-native stack.',
                'type'    => 'textarea',
                'section' => 'about',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'     => 'about_description_en',
                'value'   => 'I blend business analysis with thoughtful engineering to ship impactful digital products. Focused on PHP, JavaScript, and cloud-native stacks.',
                'type'    => 'textarea',
                'section' => 'about',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'     => 'contact_email',
                'value'   => 'halo@contoh.dev',
                'type'    => 'email',
                'section' => 'contact',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'     => 'contact_phone',
                'value'   => '+62 812 3456 7890',
                'type'    => 'text',
                'section' => 'contact',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'     => 'contact_address',
                'value'   => 'Jakarta, Indonesia',
                'type'    => 'text',
                'section' => 'contact',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'     => 'social_linkedin',
                'value'   => 'https://www.linkedin.com/in/yourprofile',
                'type'    => 'url',
                'section' => 'social',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'     => 'social_github',
                'value'   => 'https://github.com/yourusername',
                'type'    => 'url',
                'section' => 'social',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'     => 'meta_keywords',
                'value'   => 'portfolio, fullstack, codeigniter',
                'type'    => 'text',
                'section' => 'seo',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'     => 'meta_keywords_en',
                'value'   => 'portfolio, full-stack developer, codeigniter',
                'type'    => 'text',
                'section' => 'seo',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
            [
                'key'     => 'analytics_measurement_id',
                'value'   => '',
                'type'    => 'text',
                'section' => 'analytics',
                'created_at'=> $now,
                'updated_at'=> $now,
            ],
        ];

        $this->db->table('settings')->ignore(true)->insertBatch($settings);
    }
}
