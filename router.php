<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($uri, '/api/') === 0) {
    $_SERVER['SCRIPT_NAME'] = '/backend/api.php';
    require __DIR__ . '/backend/api.php';
    return;
}

if ($uri === '/') {
    $file = __DIR__ . '/frontend/index.html';
    if (file_exists($file)) {
        header('Content-Type: text/html; charset=utf-8');
        readfile($file);
        return;
    } else {
        http_response_code(404);
        echo "Frontend not found.";
        return;
    }
}

return false;