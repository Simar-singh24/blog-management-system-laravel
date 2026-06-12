<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$blogs = DB::table('blogs')->where('image', 'like', 'images/%')->get();
$count = 0;
foreach ($blogs as $b) {
    $new = preg_replace('#^images/#', '', $b->image);
    DB::table('blogs')->where('id', $b->id)->update(['image' => $new]);
    $count++;
    echo "Updated blog id {$b->id}: {$b->image} -> {$new}\n";
}

if ($count === 0) echo "No images needed normalization.\n";
else echo "Normalized {$count} blog image(s).\n";
