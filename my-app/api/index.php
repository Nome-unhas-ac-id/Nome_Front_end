<?php

$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

// Ensure writable directories exist in /tmp on Vercel's serverless environment
$storageDirs = [
    '/tmp/storage',
    '/tmp/storage/app',
    '/tmp/storage/app/public',
    '/tmp/storage/framework',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
];

foreach ($storageDirs as $dir) {
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

if (! file_exists('/tmp/database.sqlite')) {
    touch('/tmp/database.sqlite');
}

// Forward request to Laravel's standard entry point
require __DIR__.'/../public/index.php';
