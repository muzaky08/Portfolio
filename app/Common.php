<?php

// #region agent log bootstrap
(static function () {
    $logPath = 'c:/xampp/htdocs/tugaszakyCI4/.cursor/debug.log';
    $payload = [
        'sessionId'    => 'debug-session',
        'runId'        => 'ui-redesign',
        'hypothesisId' => 'BOOT',
        'location'     => 'app/Common.php',
        'message'      => 'Bootstrap entry',
        'data'         => [
            'method' => $_SERVER['REQUEST_METHOD'] ?? null,
            'uri'    => $_SERVER['REQUEST_URI'] ?? null,
        ],
        'timestamp'    => round(microtime(true) * 1000),
    ];
    if (! is_dir(dirname($logPath))) {
        @mkdir(dirname($logPath), 0775, true);
    }
    @file_put_contents($logPath, json_encode($payload) . PHP_EOL, FILE_APPEND);
})();
// #endregion

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */
