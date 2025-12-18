<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SkillModel;
use App\Services\AdminActivityLogger;
use App\Services\PortfolioCache;
use CodeIgniter\Exceptions\PageNotFoundException;

class Skills extends BaseController
{
    protected $helpers = ['form'];

    protected SkillModel $skillModel;

    public function __construct()
    {
        $this->skillModel = new SkillModel();
        helper('form');
    }

    public function index()
    {
        $skills = $this->skillModel->orderBy('category')->findAll();
        return view('admin/skills/index', ['skills' => $skills]);
    }

    public function create()
    {
        return view('admin/skills/form', ['skill' => null]);
    }

    public function store()
    {
        return $this->saveSkill();
    }

    public function edit(int $id)
    {
        $skill = $this->skillModel->find($id);
        if (! $skill) {
            throw PageNotFoundException::forPageNotFound('Skill tidak ditemukan');
        }

        return view('admin/skills/form', ['skill' => $skill]);
    }

    public function update(int $id)
    {
        return $this->saveSkill($id);
    }

    public function delete(int $id)
    {
        $this->skillModel->delete($id, true);
        AdminActivityLogger::log('skill.delete', 'Menghapus skill ID ' . $id);
        PortfolioCache::clear();
        return redirect()->to(site_url('admin/skills'))->with('success', 'Skill dihapus.');
    }

    private function saveSkill(?int $id = null)
    {
        $rules = [
            'name'        => 'required|min_length[2]',
            'category'    => 'permit_empty|max_length[60]',
            'level'       => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
            'description' => 'permit_empty|max_length[500]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $data = $this->request->getPost(['name', 'category', 'level', 'description']);

        if ($id) {
            $this->skillModel->update($id, $data);
            $message = 'Skill diperbarui.';
            AdminActivityLogger::log('skill.update', 'Memperbarui skill: ' . $data['name'], ['id' => $id]);
        } else {
            $this->skillModel->insert($data);
            $message = 'Skill ditambahkan.';
            AdminActivityLogger::log('skill.create', 'Menambahkan skill: ' . $data['name']);
        }

        PortfolioCache::clear();

        return redirect()->to(site_url('admin/skills'))->with('success', $message);
    }
}


