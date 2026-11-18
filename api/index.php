<?php

// Pintu masuk Vercel: teruskan semua request ke Laravel.
// Filesystem Vercel read-only kecuali /tmp, jadi folder tulis diarahkan ke sana.
$tmp = '/tmp/storage';
foreach (['framework/views', 'framework/cache/data', 'framework/sessions', 'logs'] as $dir) {
    if (!is_dir("$tmp/$dir")) {
        mkdir("$tmp/$dir", 0777, true);
    }
}
putenv("VIEW_COMPILED_PATH=$tmp/framework/views");
$_ENV['VIEW_COMPILED_PATH'] = "$tmp/framework/views";

require __DIR__ . '/../public/index.php';
