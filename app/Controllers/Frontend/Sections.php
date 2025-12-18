<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Services\PortfolioService;

class Sections extends BaseController
{
    protected PortfolioService $portfolioService;

    public function __construct()
    {
        $this->portfolioService = new PortfolioService();
    }

    public function activities()
    {
        $filters = [
            'keyword'    => trim((string) $this->request->getGet('keyword')),
            'category'   => $this->request->getGet('category'),
            'start_date' => $this->request->getGet('start_date'),
            'end_date'   => $this->request->getGet('end_date'),
            'sort'       => $this->request->getGet('sort'),
        ];

        if (! in_array($filters['category'], ['kerja', 'kuliah', 'lainnya'], true)) {
            $filters['category'] = null;
        }

        if (! in_array(strtolower((string) $filters['sort']), ['asc', 'desc'], true)) {
            $filters['sort'] = 'desc';
        }

        $perPage = 10;
        $page    = max(1, (int) ($this->request->getGet('page_activities') ?? 1));

        $agentLogPath = 'c:/xampp/htdocs/tugaszakyCI4/.cursor/debug.log';
        if (! is_dir(dirname($agentLogPath))) {
            @mkdir(dirname($agentLogPath), 0775, true);
        }
        $agentLog = static function (string $hypothesisId, string $location, string $message, array $data = []) use ($agentLogPath): void {
            $payload = json_encode([
                'sessionId'    => 'debug-session',
                'runId'        => 'aktivitas-debug',
                'hypothesisId' => $hypothesisId,
                'location'     => $location,
                'message'      => $message,
                'data'         => $data,
                'timestamp'    => round(microtime(true) * 1000),
            ]);
            @file_put_contents($agentLogPath, $payload . PHP_EOL, FILE_APPEND);
        };
        // #region agent log
        $agentLog('H1', 'Sections::activities:filters', 'Normalized filters', $filters);
        // #endregion

        $result = $this->portfolioService->paginatedActivities($filters, $perPage, $page);
        $pager  = $result['pager'];
        $total  = $pager->getTotal('activities');
        $start  = $total ? (($page - 1) * $perPage) + 1 : 0;
        $end    = $total ? min($start + $perPage - 1, $total) : 0;

        // #region agent log
        $agentLog('H2', 'Sections::activities:pagination', 'Pagination data', [
            'perPage' => $perPage,
            'page'    => $page,
            'total'   => $total,
            'pager'   => is_object($pager) ? get_class($pager) : gettype($pager),
        ]);
        // #endregion

        $pagerConfig = config('Pager');
        $agentLog('H3', 'Sections::activities:pagerConfig', 'Pager templates availability', [
            'hasQueryPager' => is_object($pagerConfig) && property_exists($pagerConfig, 'templates') ? array_key_exists('query_pager', $pagerConfig->templates) : null,
            'templates'     => is_object($pagerConfig) && property_exists($pagerConfig, 'templates') ? array_keys($pagerConfig->templates) : null,
        ]);

        $queryParams = array_filter([
            'keyword'    => $filters['keyword'],
            'category'   => $filters['category'],
            'start_date' => $filters['start_date'],
            'end_date'   => $filters['end_date'],
            'sort'       => $filters['sort'],
        ], static fn ($value) => $value !== null && $value !== '');

        $data   = $this->portfolioService->homepageData();
        $data['pageTitle'] = 'Aktivitas Harian';
        $data['activities'] = $result['items'];
        $data['pager'] = $pager;
        $data['filters'] = $filters;
        $data['perPage'] = $perPage;
        $data['page']    = $page;
        $data['total']   = $total;
        $data['rangeStart'] = $start;
        $data['rangeEnd'] = $end;
        $data['queryParams'] = $queryParams;

        // #region agent log
        $agentLog('H4', 'Sections::activities:view', 'View payload summary', [
            'itemsCount' => is_array($result['items']) ? count($result['items']) : null,
            'queryParams'=> $queryParams,
        ]);
        // #endregion

        return view('frontend/activities', $data);
    }

    public function biodata()
    {
        $data = $this->portfolioService->homepageData();
        $data['pageTitle'] = 'Biodata';

        return view('frontend/biodata', $data);
    }

    public function educations()
    {
        $filters = [
            'keyword' => trim((string) $this->request->getGet('keyword')),
            'level'   => $this->request->getGet('level'),
            'sort'    => $this->request->getGet('sort'),
        ];

        if (! in_array($filters['level'], ['SD', 'SMP', 'SMA', 'Kuliah'], true)) {
            $filters['level'] = null;
        }

        if (! in_array(strtolower((string) $filters['sort']), ['asc', 'desc'], true)) {
            $filters['sort'] = 'desc';
        }

        $perPage = 10;
        $page    = max(1, (int) ($this->request->getGet('page_educations') ?? 1));

        $agentLogPath = 'c:/xampp/htdocs/tugaszakyCI4/.cursor/debug.log';
        if (! is_dir(dirname($agentLogPath))) {
            @mkdir(dirname($agentLogPath), 0775, true);
        }
        $agentLog = static function (string $hypothesisId, string $location, string $message, array $data = []) use ($agentLogPath): void {
            $payload = json_encode([
                'sessionId'    => 'debug-session',
                'runId'        => 'ui-redesign',
                'hypothesisId' => $hypothesisId,
                'location'     => $location,
                'message'      => $message,
                'data'         => $data,
                'timestamp'    => round(microtime(true) * 1000),
            ]);
            @file_put_contents($agentLogPath, $payload . PHP_EOL, FILE_APPEND);
        };
        // #region agent log
        $agentLog('H1', 'Sections::educations:filters', 'Normalized filters', $filters);
        // #endregion

        $result = $this->portfolioService->paginatedEducations($filters, $perPage, $page);
        $pager  = $result['pager'];
        $total  = $pager->getTotal('educations');
        $start  = $total ? (($page - 1) * $perPage) + 1 : 0;
        $end    = $total ? min($start + $perPage - 1, $total) : 0;

        $queryParams = array_filter([
            'keyword' => $filters['keyword'],
            'level'   => $filters['level'],
            'sort'    => $filters['sort'],
        ], static fn ($value) => $value !== null && $value !== '');

        $data   = $this->portfolioService->homepageData();
        $data['pageTitle'] = 'Riwayat Pendidikan';
        $data['educations'] = $result['items'];
        $data['pager'] = $pager;
        $data['filters'] = $filters;
        $data['perPage'] = $perPage;
        $data['page']    = $page;
        $data['total']   = $total;
        $data['rangeStart'] = $start;
        $data['rangeEnd'] = $end;
        $data['queryParams'] = $queryParams;

        // #region agent log
        $agentLog('H2', 'Sections::educations:view', 'View payload summary', [
            'itemsCount' => is_array($result['items']) ? count($result['items']) : null,
            'queryParams'=> $queryParams,
            'total'      => $total,
        ]);
        // #endregion

        return view('frontend/educations', $data);
    }
}
