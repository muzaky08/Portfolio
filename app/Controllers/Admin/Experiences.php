<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ExperienceModel;
use App\Services\AdminActivityLogger;
use App\Services\PortfolioCache;
use CodeIgniter\Exceptions\PageNotFoundException;

class Experiences extends BaseController
{
    protected $helpers = ['form'];

    protected ExperienceModel $experienceModel;

    public function __construct()
    {
        $this->experienceModel = new ExperienceModel();
        helper('form');
    }

    public function index()
    {
        $experiences = $this->experienceModel->orderBy('start_date', 'DESC')->findAll();
        return view('admin/experiences/index', ['experiences' => $experiences]);
    }

    public function create()
    {
        return view('admin/experiences/form', ['experience' => null]);
    }

    public function store()
    {
        return $this->saveExperience();
    }

    public function edit(int $id)
    {
        $experience = $this->experienceModel->find($id);
        if (! $experience) {
            throw PageNotFoundException::forPageNotFound('Pengalaman tidak ditemukan');
        }

        return view('admin/experiences/form', ['experience' => $experience]);
    }

    public function update(int $id)
    {
        return $this->saveExperience($id);
    }

    public function delete(int $id)
    {
        $this->experienceModel->delete($id, true);
        AdminActivityLogger::log('experience.delete', 'Menghapus pengalaman ID ' . $id);
        PortfolioCache::clear();
        return redirect()->to(site_url('admin/experiences'))->with('success', 'Pengalaman dihapus.');
    }

    private function saveExperience(?int $id = null)
    {
        $rules = [
            'role'       => 'required|min_length[3]|max_length[120]',
            'company'    => 'required|min_length[3]|max_length[120]',
            'location'   => 'permit_empty|max_length[120]',
            'start_date' => 'required|valid_date',
            'end_date'   => 'permit_empty|valid_date',
            'description'=> 'permit_empty'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $data = $this->request->getPost(['role', 'company', 'location', 'start_date', 'end_date', 'description']);
        $data['is_current'] = $this->request->getPost('is_current') ? 1 : 0;

        if ($id) {
            $this->experienceModel->update($id, $data);
            $message = 'Pengalaman berhasil diperbarui.';
            AdminActivityLogger::log('experience.update', 'Memperbarui pengalaman: ' . $data['role'], ['id' => $id]);
        } else {
            $this->experienceModel->insert($data);
            $message = 'Pengalaman berhasil ditambahkan.';
            AdminActivityLogger::log('experience.create', 'Menambahkan pengalaman: ' . $data['role']);
        }

        PortfolioCache::clear();

        return redirect()->to(site_url('admin/experiences'))->with('success', $message);
    }
}


