<?php
// router.php — correct static file handling

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$file = __DIR__ . $uri;

// If the file exists, serve it directly
if ($uri !== '/' && file_exists($file)) {
    return false;
}

// Otherwise route everything to frontend
require __DIR__ . '/frontend/index.php';
