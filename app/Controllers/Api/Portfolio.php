<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ActivityModel;
use App\Models\BiodataModel;
use App\Models\EducationModel;
use App\Models\ProjectModel;
use App\Models\SkillModel;

class Portfolio extends BaseController
{
    public function activities()
    {
        $filters = [
            'keyword'    => trim((string) $this->request->getGet('keyword')),
            'category'   => $this->request->getGet('category'),
            'start_date' => $this->request->getGet('start_date'),
            'end_date'   => $this->request->getGet('end_date'),
            'sort'       => $this->request->getGet('sort'),
        ];

        $perPage = (int) ($this->request->getGet('per_page') ?? 10);
        $perPage = max(1, min(50, $perPage));
        $page    = max(1, (int) ($this->request->getGet('page') ?? 1));

        $model = new ActivityModel();
        $items = $model->applyFilters($filters)
            ->orderBy('activity_date', 'DESC')
            ->paginate($perPage, 'activities_api', $page);

        $details = $model->pager->getDetails('activities_api');

        return $this->response->setJSON([
            'data' => $items,
            'meta' => $details,
        ]);
    }

    public function biodata()
    {
        $profile = (new BiodataModel())->getBiodata();
        return $this->response->setJSON([
            'data' => $profile,
        ]);
    }

    public function educations()
    {
        $model = new EducationModel();
        $items = $model->orderBy('start_year', 'DESC')->findAll();

        return $this->response->setJSON(['data' => $items]);
    }

    public function projects()
    {
        $model = new ProjectModel();
        $items = $model->orderBy('completed_at', 'DESC')->findAll();

        return $this->response->setJSON(['data' => $items]);
    }

    public function skills()
    {
        $model = new SkillModel();
        $items = $model->orderBy('category')->findAll();

        return $this->response->setJSON(['data' => $items]);
    }
}

