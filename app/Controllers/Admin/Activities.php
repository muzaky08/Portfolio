<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ActivityModel;
use App\Services\AdminActivityLogger;
use App\Services\PortfolioCache;

class Activities extends BaseController
{
    protected $helpers = ['form'];

    protected ActivityModel $activityModel;

    public function __construct()
    {
        $this->activityModel = new ActivityModel();
    }

    public function index()
    {
        $agentLogPath = 'c:/xampp/htdocs/tugaszakyCI4/.cursor/debug.log';
        if (! is_dir(dirname($agentLogPath))) {
            @mkdir(dirname($agentLogPath), 0775, true);
        }
        $agentLog = static function (string $hypothesisId, string $location, string $message, array $data = []) use ($agentLogPath): void {
            $payload = json_encode([
                'sessionId'    => 'debug-session',
                'runId'        => 'admin-fix',
                'hypothesisId' => $hypothesisId,
                'location'     => $location,
                'message'      => $message,
                'data'         => $data,
                'timestamp'    => round(microtime(true) * 1000),
            ]);
            @file_put_contents($agentLogPath, $payload . PHP_EOL, FILE_APPEND);
        };

        $filters = [
            'keyword'    => trim((string) $this->request->getGet('keyword')),
            'categories' => $this->normalizeCategories($this->request->getGet('category')),
            'start_date' => $this->request->getGet('start_date'),
            'end_date'   => $this->request->getGet('end_date'),
        ];
        // #region agent log
        $agentLog('H1', 'Admin/Activities::index:filters', 'Filters normalized', $filters);
        // #endregion

        $modelFilters = [
            'keyword'    => $filters['keyword'],
            'category'   => $filters['categories'],
            'start_date' => $filters['start_date'],
            'end_date'   => $filters['end_date'],
        ];

        $sortBy  = $this->request->getGet('sort_by') ?? 'activity_date';
        $sortDir = strtolower($this->request->getGet('sort_dir') ?? 'desc');
        $sortDir = in_array($sortDir, ['asc', 'desc'], true) ? $sortDir : 'desc';

        $perPageOptions = [10, 25, 50];
        $perPage = (int) ($this->request->getGet('per_page') ?? 10);
        if (! in_array($perPage, $perPageOptions, true)) {
            $perPage = 10;
        }

        $model = clone $this->activityModel;
        $model->applyFilters($modelFilters);
        if (in_array($sortBy, ['activity_date', 'title', 'category', 'location'], true)) {
            $model->orderBy($sortBy, strtoupper($sortDir));
        } else {
            $model->orderBy('activity_date', strtoupper($sortDir));
        }

        $activities = $model->paginate($perPage, 'activities');
        $pager      = $model->pager;
        $total      = $pager->getTotal('activities');
        $current    = $pager->getCurrentPage('activities');
        $start      = $total ? (($current - 1) * $perPage) + 1 : 0;
        $end        = $total ? min($start + $perPage - 1, $total) : 0;
        // #region agent log
        $agentLog('H2', 'Admin/Activities::index:pagination', 'Pager stats', [
            'perPage' => $perPage,
            'page'    => $current,
            'total'   => $total,
            'range'   => [$start, $end],
            'pager'   => is_object($pager) ? get_class($pager) : gettype($pager),
        ]);
        // #endregion

        $queryParams = [
            'keyword'    => $filters['keyword'],
            'start_date' => $filters['start_date'],
            'end_date'   => $filters['end_date'],
            'per_page'   => $perPage,
            'sort_by'    => $sortBy,
            'sort_dir'   => $sortDir,
        ];
        if (! empty($filters['categories'])) {
            $queryParams['category'] = $filters['categories'];
        }

        return view('admin/activities/index', [
            'activities'   => $activities,
            'pager'        => $pager,
            'filters'      => $filters,
            'sortBy'       => $sortBy,
            'sortDir'      => $sortDir,
            'perPage'      => $perPage,
            'perPageOpts'  => $perPageOptions,
            'total'        => $total,
            'rangeStart'   => $start,
            'rangeEnd'     => $end,
            'queryParams'  => $queryParams,
        ]);
    }

    public function create()
    {
        return view('admin/activities/form', ['activity' => null]);
    }

    public function store()
    {
        return $this->saveActivity();
    }

    public function edit(int $id)
    {
        $activity = $this->activityModel->find($id);
        if (! $activity) {
            return redirect()->to(site_url('admin/activities'))->with('error', 'Aktivitas tidak ditemukan.');
        }

        return view('admin/activities/form', ['activity' => $activity]);
    }

    public function update(int $id)
    {
        return $this->saveActivity($id);
    }

    public function delete(int $id)
    {
        $this->activityModel->delete($id, true);
        AdminActivityLogger::log('activity.delete', 'Menghapus aktivitas ID ' . $id);
        PortfolioCache::clear();
        return redirect()->back()->with('success', 'Aktivitas dihapus.');
    }

    public function bulkDelete()
    {
        $ids = $this->request->getPost('selected_ids');
        if (! empty($ids)) {
            $this->activityModel->whereIn('id', $ids)->delete();
            AdminActivityLogger::log('activity.bulk_delete', 'Menghapus aktivitas massal', ['count' => count($ids)]);
            PortfolioCache::clear();
            return redirect()->back()->with('success', 'Aktivitas terpilih dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
    }

    public function export(string $format = 'csv')
    {
        $filters = [
            'keyword'    => trim((string) $this->request->getGet('keyword')),
            'category'   => $this->normalizeCategories($this->request->getGet('category')),
            'start_date' => $this->request->getGet('start_date'),
            'end_date'   => $this->request->getGet('end_date'),
        ];

        $model = clone $this->activityModel;
        $rows  = $model->applyFilters($filters)->orderBy('activity_date', 'DESC')->findAll();

        $filename = 'activities-' . date('Ymd_His');
        $content  = "Judul,Deskripsi,Tanggal,Lokasi,Kategori\r\n";
        foreach ($rows as $row) {
            $content .= sprintf('"%s","%s","%s","%s","%s"\r\n',
                $this->csvField($row['title']),
                $this->csvField($row['description']),
                $row['activity_date'],
                $this->csvField((string) $row['location']),
                $row['category']
            );
        }

        $mime = $format === 'excel' ? 'application/vnd.ms-excel' : 'text/csv';

        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '.csv"')
            ->setBody($content);
    }

    private function saveActivity(?int $id = null)
    {
        $rules = [
            'title'         => 'required|min_length[3]|max_length[180]',
            'description'   => 'permit_empty',
            'activity_date' => 'required|valid_date',
            'location'      => 'permit_empty|max_length[160]',
            'category'      => 'required|in_list[kerja,kuliah,lainnya]',
            'icon'          => 'permit_empty|max_length[120]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $data = $this->request->getPost(['title', 'description', 'activity_date', 'location', 'category', 'icon']);

        if ($id) {
            $this->activityModel->update($id, $data);
            $message = 'Aktivitas diperbarui.';
            AdminActivityLogger::log('activity.update', 'Memperbarui aktivitas: ' . $data['title'], ['id' => $id]);
        } else {
            $this->activityModel->insert($data);
            $message = 'Aktivitas ditambahkan.';
            AdminActivityLogger::log('activity.create', 'Menambahkan aktivitas: ' . $data['title']);
        }

        PortfolioCache::clear();

        return redirect()->to(site_url('admin/activities'))->with('success', $message);
    }

    private function normalizeCategories($input): array
    {
        if ($input === null || $input === '') {
            return [];
        }

        $categories = is_array($input) ? $input : [$input];
        $allowed = ['kerja', 'kuliah', 'lainnya'];

        return array_values(array_filter($categories, static function ($value) use ($allowed) {
            return in_array($value, $allowed, true);
        }));
    }

    private function csvField(?string $value): string
    {
        $value = $value ?? '';
        return str_replace('"', '""', $value);
    }
}
