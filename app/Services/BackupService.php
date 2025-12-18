<?php

namespace App\Services;

use ZipArchive;

class BackupService
{
    private array $tables = [
        'users',
        'settings',
        'skills',
        'projects',
        'experiences',
        'activities',
        'educations',
        'biodata',
        'social_links',
        'messages',
        'admin_activity_logs',
    ];

    public function generate(): string
    {
        $db   = \Config\Database::connect();
        $data = [];

        foreach ($this->tables as $table) {
            if (! $db->tableExists($table)) {
                continue;
            }
            $data[$table] = $db->table($table)->get()->getResultArray();
        }

        $payload   = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $directory = WRITEPATH . 'backups';
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $timestamp = date('Ymd_His');
        $archiveName = $directory . DIRECTORY_SEPARATOR . "backup-{$timestamp}.zip";

        if (class_exists(ZipArchive::class)) {
            $zip = new ZipArchive();
            if ($zip->open($archiveName, ZipArchive::CREATE) === true) {
                $zip->addFromString('backup.json', $payload);
                $zip->close();
                return $archiveName;
            }
        }

        $fallbackPath = $directory . DIRECTORY_SEPARATOR . "backup-{$timestamp}.json";
        file_put_contents($fallbackPath, $payload);
        return $fallbackPath;
    }

    public function listArchives(): array
    {
        $directory = WRITEPATH . 'backups';
        if (! is_dir($directory)) {
            return [];
        }

        $files = glob($directory . DIRECTORY_SEPARATOR . '*.{zip,json}', GLOB_BRACE) ?: [];
        rsort($files);

        return array_map(static function ($path) {
            return [
                'name' => basename($path),
                'path' => $path,
                'size' => filesize($path),
                'updated_at' => filemtime($path),
            ];
        }, $files);
    }
}

