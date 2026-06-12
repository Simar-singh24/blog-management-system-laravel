<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$images = [
    1 => 'blog1.jpg',
    2 => 'blog2.jpg',
    3 => 'blog3.jpg',
    4 => 'blog4.jpg',
    5 => 'blog5.jpg',
    6 => 'blog6.jpg',
];

foreach ($images as $id => $path) {
    DB::table('blogs')->where('id', $id)->update(['image' => $path]);
}

echo "blog images updated\n";
