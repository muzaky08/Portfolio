<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ActivityModel;
use App\Models\EducationModel;
use App\Models\ProjectModel;
use App\Models\ExperienceModel;

class Search extends BaseController
{
    public function live()
    {
        if (! $this->request->isAJAX()) {
            return $this->response->setStatusCode(400, 'Invalid request');
        }

        $keyword = trim((string) $this->request->getGet('q'));
        $history = session('search_history') ?? [];

        if ($keyword !== '') {
            $history = array_values(array_unique(array_filter([$keyword, ...$history])));
            $history = array_slice($history, 0, 5);
            session()->set('search_history', $history);
        }

        if ($keyword === '') {
            return $this->response->setJSON([
                'results' => [],
                'history' => $history,
            ]);
        }

        $results = array_merge(
            $this->searchActivities($keyword),
            $this->searchProjects($keyword),
            $this->searchEducations($keyword),
            $this->searchExperiences($keyword)
        );

        return $this->response->setJSON([
            'results' => $results,
            'history' => $history,
        ]);
    }

    protected function searchActivities(string $keyword): array
    {
        $rows = (new ActivityModel())
            ->groupStart()
                ->like('title', $keyword)
                ->orLike('description', $keyword)
                ->orLike('location', $keyword)
            ->groupEnd()
            ->orderBy('activity_date', 'DESC')
            ->findAll(5);

        return array_map(function ($row) use ($keyword) {
            return [
                'section' => 'Aktivitas',
                'title'   => $this->highlight($row['title'], $keyword),
                'snippet' => $this->snippet((string) $row['description'], $keyword),
                'url'     => site_url('admin/activities?keyword=' . urlencode($row['title'])),
            ];
        }, $rows);
    }

    protected function searchProjects(string $keyword): array
    {
        $rows = (new ProjectModel())
            ->groupStart()
                ->like('title', $keyword)
                ->orLike('summary', $keyword)
            ->groupEnd()
            ->findAll(5);

        return array_map(function ($row) use ($keyword) {
            return [
                'section' => 'Proyek',
                'title'   => $this->highlight($row['title'], $keyword),
                'snippet' => $this->snippet((string) $row['summary'], $keyword),
                'url'     => site_url('admin/projects?keyword=' . urlencode($row['title'])),
            ];
        }, $rows);
    }

    protected function searchEducations(string $keyword): array
    {
        $rows = (new EducationModel())
            ->like('institution', $keyword)
            ->orLike('description', $keyword)
            ->findAll(5);

        return array_map(function ($row) use ($keyword) {
            return [
                'section' => 'Pendidikan',
                'title'   => $this->highlight($row['institution'], $keyword),
                'snippet' => $this->snippet((string) $row['description'], $keyword),
                'url'     => site_url('admin/educations?keyword=' . urlencode($row['institution'])),
            ];
        }, $rows);
    }

    protected function searchExperiences(string $keyword): array
    {
        $rows = (new ExperienceModel())
            ->groupStart()
                ->like('role', $keyword)
                ->orLike('company', $keyword)
            ->groupEnd()
            ->findAll(5);

        return array_map(function ($row) use ($keyword) {
            return [
                'section' => 'Pengalaman',
                'title'   => $this->highlight($row['role'], $keyword),
                'snippet' => $this->snippet((string) $row['company'], $keyword),
                'url'     => site_url('admin/experiences'),
            ];
        }, $rows);
    }

    private function highlight(string $text, string $keyword): string
    {
        $escaped = esc($text);
        return preg_replace('/(' . preg_quote($keyword, '/') . ')/iu', '<mark>$1</mark>', $escaped) ?? $escaped;
    }

    private function snippet(string $text, string $keyword, int $limit = 120): string
    {
        $text = strip_tags($text);
        if (mb_strlen($text) > $limit) {
            $text = mb_substr($text, 0, $limit) . '…';
        }

        return $this->highlight($text, $keyword);
    }
}
