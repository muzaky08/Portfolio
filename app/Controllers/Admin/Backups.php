<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\AdminActivityLogger;
use App\Services\BackupService;

class Backups extends BaseController
{
    protected BackupService $backupService;

    public function __construct()
    {
        $this->backupService = new BackupService();
    }

    public function index()
    {
        return view('admin/backups/index', [
            'archives' => $this->backupService->listArchives(),
        ]);
    }

    public function generate()
    {
        $path = $this->backupService->generate();
        AdminActivityLogger::log('backup.generate', 'Backup dibuat: ' . basename($path));

        return $this->response->download($path, null)
            ->setFileName(basename($path));
    }

    public function download(string $filename)
    {
        $safeName = basename($filename);
        $path = WRITEPATH . 'backups' . DIRECTORY_SEPARATOR . $safeName;
        if (! is_file($path)) {
            return redirect()->back()->with('error', 'File backup tidak ditemukan.');
        }

        AdminActivityLogger::log('backup.download', 'Download backup: ' . $safeName);

        return $this->response->download($path, null)->setFileName($safeName);
    }
}

