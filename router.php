<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($uri, '/api/') === 0) {
    $_SERVER['SCRIPT_NAME'] = '/backend/api.php';
    require __DIR__ . '/backend/api.php';
    return;
}

return false;