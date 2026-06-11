<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
echo "default: " . config('database.default') . PHP_EOL;
echo "sqlite database: " . config('database.connections.sqlite.database') . PHP_EOL;
echo "env DB_DATABASE: " . env('DB_DATABASE') . PHP_EOL;
echo "app url: " . env('APP_URL') . PHP_EOL;
