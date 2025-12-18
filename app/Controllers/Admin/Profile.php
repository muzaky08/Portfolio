<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BiodataModel;
use App\Models\SocialLinkModel;
use App\Services\AdminActivityLogger;
use App\Services\PortfolioCache;
use CodeIgniter\Config\Services;

class Profile extends BaseController
{
    protected $helpers = ['form'];

    protected BiodataModel $biodataModel;
    protected SocialLinkModel $socialLinkModel;

    public function __construct()
    {
        $this->biodataModel    = new BiodataModel();
        $this->socialLinkModel = new SocialLinkModel();
    }

    public function index()
    {
        $profile = $this->biodataModel->getBiodata();
        return view('admin/profile/index', ['profile' => $profile]);
    }

    public function update()
    {
        $rules = [
            'full_name' => 'required|min_length[3]|max_length[160]',
            'job_title' => 'required|min_length[2]|max_length[160]',
            'email'     => 'required|valid_email',
            'phone'     => 'permit_empty|max_length[60]',
            'address'   => 'permit_empty|max_length[255]',
            'short_bio' => 'permit_empty',
            'photo'     => 'permit_empty|is_image[photo]|max_size[photo,2048]',
            'cv_file'   => 'permit_empty|max_size[cv_file,5120]|ext_in[cv_file,pdf]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $profile = $this->biodataModel->getBiodata();
        $data    = $this->request->getPost([
            'full_name', 'job_title', 'address', 'email', 'phone', 'short_bio',
        ]);

        $data['skills'] = json_encode($this->mapSkills());
        $socialLinks    = $this->mapSocialLinks();

        $uploadedFiles = [];
        if ($photo = $this->request->getFile('photo')) {
            if ($photo->isValid() && ! $photo->hasMoved()) {
                $data['photo']     = $this->moveUpload($photo, 'profile', $profile['photo'] ?? null);
                $uploadedFiles[]   = $data['photo'];
            }
        }

        if ($cv = $this->request->getFile('cv_file')) {
            if ($cv->isValid() && ! $cv->hasMoved()) {
                $data['cv_path']   = $this->moveUpload($cv, 'docs', $profile['cv_path'] ?? null);
                $uploadedFiles[]   = $data['cv_path'];
            }
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            if ($profile) {
                $this->biodataModel->update($profile['id'], $data);
                $biodataId = (int) $profile['id'];
            } else {
                $this->biodataModel->insert($data);
                $biodataId = (int) $this->biodataModel->getInsertID();
            }

            $this->socialLinkModel->replaceLinks($biodataId, $socialLinks);
            $db->transCommit();

            PortfolioCache::clear();
            AdminActivityLogger::log('profile.update', 'Memperbarui biodata');
        } catch (\Throwable $throwable) {
            $db->transRollback();
            foreach ($uploadedFiles as $relativePath) {
                $this->cleanupUploadedFile($relativePath);
            }

            log_message('error', 'Gagal memperbarui biodata: {error}', ['error' => $throwable->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan biodata.')->withInput();
        }

        return redirect()->back()->with('success', 'Biodata berhasil disimpan.');
    }

    public function backup()
    {
        $profile = $this->biodataModel->getBiodata();
        if (! $profile) {
            return redirect()->back()->with('error', 'Belum ada biodata yang bisa di-backup.');
        }

        $filename = 'profile-backup-' . date('Ymd_His') . '.json';
        AdminActivityLogger::log('profile.backup', 'Membuat backup biodata');
        return $this->response->setHeader('Content-Type', 'application/json')
            ->setHeader('Content-Disposition', 'attachment; filename=' . $filename)
            ->setBody(json_encode($profile, JSON_PRETTY_PRINT));
    }

    public function restore()
    {
        $file = $this->request->getFile('backup_file');
        if (! $file || ! $file->isValid()) {
            return redirect()->back()->with('error', 'File backup tidak valid.');
        }

        $json = json_decode($file->getContents(), true);
        if (! is_array($json)) {
            return redirect()->back()->with('error', 'Format file tidak dikenal.');
        }

        $links = $json['social_links'] ?? [];
        unset($json['id'], $json['created_at'], $json['updated_at'], $json['social_links']);
        if (isset($json['skills']) && is_array($json['skills'])) {
            $json['skills'] = json_encode($json['skills']);
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $this->socialLinkModel->where('id >', 0)->delete();
            $this->biodataModel->where('id >', 0)->delete();

            $this->biodataModel->insert($json);
            $biodataId = (int) $this->biodataModel->getInsertID();
            $this->socialLinkModel->replaceLinks($biodataId, $this->normalizeImportedLinks($links));
            $db->transCommit();

            PortfolioCache::clear();
            AdminActivityLogger::log('profile.restore', 'Restore biodata dari file');
        } catch (\Throwable $throwable) {
            $db->transRollback();
            log_message('error', 'Gagal restore biodata: {error}', ['error' => $throwable->getMessage()]);
            return redirect()->back()->with('error', 'Gagal mengimpor file backup.');
        }

        return redirect()->back()->with('success', 'Biodata berhasil direstorasi.');
    }

    private function moveUpload($file, string $folder, ?string $oldPath = null): string
    {
        $directory = FCPATH . 'uploads/' . $folder;
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $newName = $file->getRandomName();
        $file->move($directory, $newName, true);

        $absolutePath = $directory . DIRECTORY_SEPARATOR . $newName;

        if ($folder === 'profile') {
            try {
                Services::image()
                    ->withFile($absolutePath)
                    ->resize(800, 800, true, 'height')
                    ->save($absolutePath, 85);
            } catch (\Throwable $throwable) {
                log_message('warning', 'Optimasi foto profil gagal: {error}', ['error' => $throwable->getMessage()]);
            }
        }

        if ($oldPath && is_file(FCPATH . $oldPath)) {
            @unlink(FCPATH . $oldPath);
        }

        return 'uploads/' . $folder . '/' . $newName;
    }

    private function cleanupUploadedFile(?string $relativePath): void
    {
        if ($relativePath && is_file(FCPATH . $relativePath)) {
            @unlink(FCPATH . $relativePath);
        }
    }

    private function mapSkills(): array
    {
        $labels = $this->request->getPost('skill_label') ?? [];
        $levels = $this->request->getPost('skill_level') ?? [];
        $skills = [];
        foreach ($labels as $index => $label) {
            $label = trim($label);
            if ($label === '') {
                continue;
            }
            $level = (int) ($levels[$index] ?? 0);
            $level = max(1, min(100, $level));
            $skills[] = ['label' => $label, 'level' => $level];
        }
        return $skills;
    }

    private function mapSocialLinks(): array
    {
        $labels = $this->request->getPost('social_label') ?? [];
        $urls   = $this->request->getPost('social_url') ?? [];
        $icons  = $this->request->getPost('social_icon') ?? [];
        $links  = [];
        foreach ($labels as $index => $label) {
            $label = trim($label);
            $url   = trim($urls[$index] ?? '');
            if ($label === '' || $url === '' || ! filter_var($url, FILTER_VALIDATE_URL)) {
                continue;
            }
            $links[] = [
                'label'      => $label,
                'url'        => $url,
                'icon'       => trim($icons[$index] ?? 'bi-link-45deg'),
                'sort_order' => $index,
            ];
        }
        return $links;
    }

    private function normalizeImportedLinks(array $links): array
    {
        $cleaned = [];
        foreach ($links as $index => $link) {
            $label = trim($link['label'] ?? '');
            $url   = trim($link['url'] ?? '');
            if ($label === '' || $url === '' || ! filter_var($url, FILTER_VALIDATE_URL)) {
                continue;
            }
            $cleaned[] = [
                'label'      => $label,
                'url'        => $url,
                'icon'       => trim($link['icon'] ?? 'bi-link-45deg'),
                'sort_order' => $index,
            ];
        }

        return $cleaned;
    }
}
