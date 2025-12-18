<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;
use App\Services\AdminActivityLogger;
use App\Services\PortfolioCache;

class Settings extends BaseController
{
    protected $helpers = ['form'];

    protected SettingModel $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
        helper('form');
    }

    public function index()
    {
        $data = [
            'settings' => $this->settingModel->getPairs(),
            'groups'   => $this->groups(),
        ];

        return view('admin/settings/index', $data);
    }

    public function update()
    {
        $rules = [];
        foreach ($this->groups() as $fields) {
            foreach ($fields as $key => $meta) {
                $rules[$key] = $meta['rules'];
            }
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            foreach ($this->groups() as $section => $fields) {
                $payload = [];
                foreach ($fields as $key => $meta) {
                    $payload[$key] = [
                        'value' => $this->request->getPost($key),
                        'type'  => $meta['type'] ?? 'text',
                    ];
                }
                $this->settingModel->sync($payload, $section);
            }

            $db->transCommit();
            PortfolioCache::clear();
            AdminActivityLogger::log('settings.update', 'Memperbarui pengaturan situs');
        } catch (\Throwable $throwable) {
            $db->transRollback();
            log_message('error', 'Gagal menyimpan pengaturan: {error}', ['error' => $throwable->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan pengaturan.')->withInput();
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    private function groups(): array
    {
        return [
            'hero' => [
                'hero_headline'    => ['label' => 'Judul Utama', 'rules' => 'required|min_length[5]', 'type' => 'input'],
                'hero_subheadline' => ['label' => 'Subjudul', 'rules' => 'permit_empty|max_length[255]', 'type' => 'textarea'],
                'hero_cta_text'    => ['label' => 'Teks Tombol', 'rules' => 'permit_empty|max_length[50]', 'type' => 'input'],
                'hero_cta_link'    => ['label' => 'Link Tombol', 'rules' => 'permit_empty|max_length[100]', 'type' => 'input'],
                'hero_headline_en'    => ['label' => 'Judul Utama (EN)', 'rules' => 'permit_empty|max_length[160]', 'type' => 'input'],
                'hero_subheadline_en' => ['label' => 'Subjudul (EN)', 'rules' => 'permit_empty|max_length[255]', 'type' => 'textarea'],
            ],
            'about' => [
                'about_summary'     => ['label' => 'Ringkasan', 'rules' => 'permit_empty|max_length[255]', 'type' => 'textarea'],
                'about_description' => ['label' => 'Deskripsi', 'rules' => 'permit_empty', 'type' => 'textarea'],
                'about_summary_en'     => ['label' => 'Ringkasan (EN)', 'rules' => 'permit_empty|max_length[255]', 'type' => 'textarea'],
                'about_description_en' => ['label' => 'Deskripsi (EN)', 'rules' => 'permit_empty', 'type' => 'textarea'],
            ],
            'contact' => [
                'contact_email'   => ['label' => 'Email', 'rules' => 'permit_empty|valid_email', 'type' => 'input'],
                'contact_phone'   => ['label' => 'Telepon', 'rules' => 'permit_empty|max_length[60]', 'type' => 'input'],
                'contact_address' => ['label' => 'Alamat', 'rules' => 'permit_empty|max_length[255]', 'type' => 'textarea'],
            ],
            'social' => [
                'social_linkedin' => ['label' => 'LinkedIn', 'rules' => 'permit_empty|valid_url', 'type' => 'input'],
                'social_github'   => ['label' => 'GitHub', 'rules' => 'permit_empty|valid_url', 'type' => 'input'],
            ],
            'seo' => [
                'meta_keywords' => ['label' => 'Meta Keywords', 'rules' => 'permit_empty|max_length[255]', 'type' => 'input'],
                'meta_keywords_en' => ['label' => 'Meta Keywords (EN)', 'rules' => 'permit_empty|max_length[255]', 'type' => 'input'],
            ],
            'analytics' => [
                'analytics_measurement_id' => ['label' => 'Google Analytics Measurement ID', 'rules' => 'permit_empty|max_length[40]', 'type' => 'input'],
            ],
        ];
    }
}


