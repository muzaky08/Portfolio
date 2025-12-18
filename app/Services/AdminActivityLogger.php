<?php

namespace App\Services;

use App\Models\AdminActivityLogModel;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use Config\Services;

class AdminActivityLogger
{
    public static function log(string $action, string $description, array $context = []): void
    {
        try {
            $request = Services::request();
            $session = Services::session();
            $model   = new AdminActivityLogModel();
            $userId  = $session->get('user_id');
            $userName = $session->get('user_name');

            $ipAddress = null;
            $userAgent = null;

            if ($request instanceof IncomingRequest) {
                $ipAddress = $request->getIPAddress();
                $userAgent = (string) $request->getUserAgent();
            } elseif ($request instanceof CLIRequest) {
                $ipAddress = 'CLI';
                $userAgent = 'CLI';
            }

            $model->insert([
                'user_id'    => $userId,
                'user_name'  => $userName,
                'action'     => $action,
                'description'=> $description,
                'context'    => $context ? json_encode($context, JSON_UNESCAPED_UNICODE) : null,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $throwable) {
            log_message('error', 'Gagal mencatat activity log: {error}', ['error' => $throwable->getMessage()]);
        }
    }
}
