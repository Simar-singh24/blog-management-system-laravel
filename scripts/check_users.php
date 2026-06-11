<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;
$count = DB::table('users')->count();
echo "users count: $count\n";
$user = DB::table('users')->first();
if($user) echo "first user: {$user->email}\n";
