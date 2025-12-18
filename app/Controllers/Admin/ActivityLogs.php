<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminActivityLogModel;
use App\Models\UserModel;

class ActivityLogs extends BaseController
{
    protected AdminActivityLogModel $logModel;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->logModel  = new AdminActivityLogModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $filters = [
            'keyword'    => trim((string) $this->request->getGet('keyword')),
            'user_id'    => $this->request->getGet('user_id'),
            'start_date' => $this->request->getGet('start_date'),
            'end_date'   => $this->request->getGet('end_date'),
        ];

        $perPageOptions = [10, 25, 50];
        $perPage = (int) ($this->request->getGet('per_page') ?? 10);
        if (! in_array($perPage, $perPageOptions, true)) {
            $perPage = 10;
        }

        $model = clone $this->logModel;
        $model->applyFilters($filters);
        $logs  = $model->orderBy('created_at', 'DESC')->paginate($perPage, 'activity_logs');
        $pager = $model->pager;
        $total = $pager->getTotal('activity_logs');
        $current = $pager->getCurrentPage('activity_logs');
        $start = $total ? (($current - 1) * $perPage) + 1 : 0;
        $end   = $total ? min($start + $perPage - 1, $total) : 0;

        $queryParams = array_filter([
            'keyword'    => $filters['keyword'],
            'user_id'    => $filters['user_id'],
            'start_date' => $filters['start_date'],
            'end_date'   => $filters['end_date'],
            'per_page'   => $perPage,
        ], static fn ($value) => $value !== null && $value !== '');

        return view('admin/activity_logs/index', [
            'logs'        => $logs,
            'filters'     => $filters,
            'pager'       => $pager,
            'users'       => $this->userModel->findAll(),
            'perPage'     => $perPage,
            'perPageOpts' => $perPageOptions,
            'rangeStart'  => $start,
            'rangeEnd'    => $end,
            'total'       => $total,
            'queryParams' => $queryParams,
        ]);
    }
}

