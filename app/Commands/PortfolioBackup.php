<?php

namespace App\Commands;

use App\Services\AdminActivityLogger;
use App\Services\BackupService;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class PortfolioBackup extends BaseCommand
{
    protected $group       = 'Portfolio';
    protected $name        = 'portfolio:backup';
    protected $description = 'Generate a backup archive for the portfolio CMS.';

    public function run(array $params)
    {
        $service = new BackupService();
        $path    = $service->generate();

        AdminActivityLogger::log('backup.cli', 'Backup dibuat via CLI: ' . basename($path));

        CLI::write('Backup created at: ' . $path, 'green');
    }
}

