<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProjectModel;
use App\Services\AdminActivityLogger;
use App\Services\PortfolioCache;
use CodeIgniter\Exceptions\PageNotFoundException;

class Projects extends BaseController
{
    protected $helpers = ['form', 'text'];

    protected ProjectModel $projectModel;

    public function __construct()
    {
        $this->projectModel = new ProjectModel();
        helper(['form', 'text']);
    }

    public function index()
    {
        $projects = $this->projectModel->orderBy('created_at', 'DESC')->findAll();
        return view('admin/projects/index', ['projects' => $projects]);
    }

    public function create()
    {
        return view('admin/projects/form', ['project' => null]);
    }

    public function store()
    {
        return $this->saveProject();
    }

    public function edit(int $id)
    {
        $project = $this->projectModel->find($id);
        if (! $project) {
            throw PageNotFoundException::forPageNotFound('Project tidak ditemukan');
        }

        return view('admin/projects/form', ['project' => $project]);
    }

    public function update(int $id)
    {
        return $this->saveProject($id);
    }

    public function delete(int $id)
    {
        $project = $this->projectModel->find($id);
        if ($project) {
            $this->projectModel->delete($id, true);
            $this->removeImage($project['image'] ?? null);
            PortfolioCache::clear();
            AdminActivityLogger::log('project.delete', 'Menghapus proyek: ' . ($project['title'] ?? $id));
        }

        return redirect()->to(site_url('admin/projects'))->with('success', 'Project berhasil dihapus.');
    }

    private function saveProject(?int $id = null)
    {
        $rules = [
            'title'        => 'required|min_length[4]|max_length[150]',
            'summary'      => 'permit_empty|max_length[500]',
            'description'  => 'permit_empty',
            'technologies' => 'permit_empty|max_length[255]',
            'project_url'  => 'permit_empty|valid_url',
            'completed_at' => 'permit_empty|valid_date',
            'image'        => 'permit_empty|is_image[image]|max_size[image,2048]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $existing = $id ? $this->projectModel->find($id) : null;

        $data = $this->request->getPost([
            'title', 'summary', 'description', 'technologies', 'project_url', 'client', 'completed_at'
        ]);
        $data['slug']        = url_title($data['title'], '-', true);
        $data['is_featured'] = $this->request->getPost('is_featured') ? 1 : 0;

        $imagePath = $this->handleUpload($this->request->getFile('image'), $existing['image'] ?? null);
        if ($imagePath) {
            $data['image'] = $imagePath;
        }

        if ($id) {
            $this->projectModel->update($id, $data);
            $message = 'Project berhasil diperbarui.';
            AdminActivityLogger::log('project.update', 'Memperbarui proyek: ' . $data['title'], ['id' => $id]);
        } else {
            $this->projectModel->insert($data);
            $message = 'Project berhasil ditambahkan.';
            AdminActivityLogger::log('project.create', 'Menambahkan proyek: ' . $data['title']);
        }

        PortfolioCache::clear();

        return redirect()->to(site_url('admin/projects'))->with('success', $message);
    }

    private function handleUpload($image, ?string $existing = null): ?string
    {
        if (! $image || ! $image->isValid() || $image->hasMoved()) {
            return null;
        }

        $uploadPath = FCPATH . 'uploads/projects';
        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $newName = $image->getRandomName();
        $image->move($uploadPath, $newName, true);

        if ($existing) {
            $this->removeImage($existing);
        }

        return 'uploads/projects/' . $newName;
    }

    private function removeImage(?string $path): void
    {
        if ($path && is_file(FCPATH . $path)) {
            @unlink(FCPATH . $path);
        }
    }
}


