<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EducationModel;
use App\Services\AdminActivityLogger;
use App\Services\PortfolioCache;

class Educations extends BaseController
{
    protected $helpers = ['form'];

    protected EducationModel $educationModel;

    public function __construct()
    {
        $this->educationModel = new EducationModel();
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
            'keyword' => trim((string) $this->request->getGet('keyword')),
            'level'   => $this->request->getGet('level'),
        ];
        // #region agent log
        $agentLog('H1', 'Admin/Educations::index:filters', 'Filters normalized', $filters);
        // #endregion

        $sort = strtolower($this->request->getGet('sort') ?? 'desc');
        $sort = in_array($sort, ['asc', 'desc'], true) ? $sort : 'desc';
        $filters['sort'] = $sort;

        $perPageOptions = [10, 25, 50];
        $perPage = (int) ($this->request->getGet('per_page') ?? 10);
        if (! in_array($perPage, $perPageOptions, true)) {
            $perPage = 10;
        }

        $model = clone $this->educationModel;
        // Hindari SQL error karena peng-escape kolom gabungan; pisahkan order dengan escape=false.
        $model->applyFilters($filters)
              ->orderBy('sort_order IS NULL', 'ASC', false)
              ->orderBy('sort_order', 'ASC')
              ->orderBy('start_year', strtoupper($sort));

        $educations = $model->paginate($perPage, 'educations');
        $pager      = $model->pager;
        $total      = $pager->getTotal('educations');
        $current    = $pager->getCurrentPage('educations');
        $start      = $total ? (($current - 1) * $perPage) + 1 : 0;
        $end        = $total ? min($start + $perPage - 1, $total) : 0;
        // #region agent log
        $agentLog('H2', 'Admin/Educations::index:pagination', 'Pager stats', [
            'perPage' => $perPage,
            'page'    => $current,
            'total'   => $total,
            'range'   => [$start, $end],
            'pager'   => is_object($pager) ? get_class($pager) : gettype($pager),
        ]);
        // #endregion

        $queryParams = [
            'keyword'  => $filters['keyword'],
            'level'    => $filters['level'],
            'sort'     => $sort,
            'per_page' => $perPage,
        ];

        return view('admin/educations/index', [
            'educations'  => $educations,
            'filters'     => $filters,
            'sort'        => $sort,
            'pager'       => $pager,
            'perPage'     => $perPage,
            'perPageOpts' => $perPageOptions,
            'total'       => $total,
            'rangeStart'  => $start,
            'rangeEnd'    => $end,
            'queryParams' => $queryParams,
        ]);
    }

    public function create()
    {
        return view('admin/educations/form', ['education' => null]);
    }

    public function store()
    {
        return $this->saveEducation();
    }

    public function edit(int $id)
    {
        $education = $this->educationModel->find($id);
        if (! $education) {
            return redirect()->to(site_url('admin/educations'))->with('error', 'Data pendidikan tidak ditemukan.');
        }

        return view('admin/educations/form', ['education' => $education]);
    }

    public function update(int $id)
    {
        return $this->saveEducation($id);
    }

    public function delete(int $id)
    {
        $education = $this->educationModel->find($id);
        if ($education) {
            $this->educationModel->delete($id, true);
            if (! empty($education['logo']) && is_file(FCPATH . $education['logo'])) {
                @unlink(FCPATH . $education['logo']);
            }
            PortfolioCache::clear();
            AdminActivityLogger::log('education.delete', 'Menghapus pendidikan: ' . ($education['institution'] ?? $id));
        }
        return redirect()->back()->with('success', 'Data dihapus.');
    }

    private function saveEducation(?int $id = null)
    {
        $rules = [
            'institution' => 'required|min_length[3]|max_length[160]',
            'level'       => 'required|in_list[SD,SMP,SMA,Kuliah]',
            'major'       => 'permit_empty|max_length[120]',
            'start_year'  => 'required|integer|greater_than_equal_to[1900]|less_than_equal_to[' . date('Y') . ']',
            'end_year'    => 'required|integer|greater_than_equal_to[1900]|less_than_equal_to[' . (date('Y') + 10) . ']',
            'description' => 'permit_empty',
            'sort_order'  => 'permit_empty|integer',
            'logo'        => 'permit_empty|is_image[logo]|max_size[logo,2048]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $data = $this->request->getPost([
            'institution', 'level', 'major', 'start_year', 'end_year', 'description', 'sort_order'
        ]);
        $data['start_year'] = (int) $data['start_year'];
        $data['end_year']   = (int) $data['end_year'];

        if ($data['start_year'] > $data['end_year']) {
            return redirect()->back()->with('error', 'Tahun mulai tidak boleh melebihi tahun selesai.')->withInput();
        }

        // overlap validation
        $builder = $this->educationModel->where('level', $data['level']);
        if ($id) {
            $builder->where('id !=', $id);
        }
        $overlap = $builder->groupStart()
            ->where('start_year <=', $data['end_year'])
            ->where('end_year >=', $data['start_year'])
            ->groupEnd()
            ->first();
        if ($overlap) {
            return redirect()->back()->with('error', 'Rentang tahun bertabrakan dengan entri lain untuk jenjang ' . $data['level'])->withInput();
        }

        if ($logo = $this->request->getFile('logo')) {
            if ($logo->isValid() && ! $logo->hasMoved()) {
                $data['logo'] = $this->uploadLogo($logo, $id ? ($this->educationModel->find($id)['logo'] ?? null) : null);
            }
        }

        if ($id) {
            $this->educationModel->update($id, $data);
            $message = 'Data pendidikan diperbarui.';
            AdminActivityLogger::log('education.update', 'Memperbarui pendidikan: ' . $data['institution'], ['id' => $id]);
        } else {
            $this->educationModel->insert($data);
            $message = 'Data pendidikan ditambahkan.';
            AdminActivityLogger::log('education.create', 'Menambahkan pendidikan: ' . $data['institution']);
        }

        PortfolioCache::clear();

        return redirect()->to(site_url('admin/educations'))->with('success', $message);
    }

    private function uploadLogo($file, ?string $existing = null): string
    {
        $directory = FCPATH . 'uploads/educations';
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $newName = $file->getRandomName();
        $file->move($directory, $newName, true);

        if ($existing && is_file(FCPATH . $existing)) {
            @unlink(FCPATH . $existing);
        }

        return 'uploads/educations/' . $newName;
    }
}
