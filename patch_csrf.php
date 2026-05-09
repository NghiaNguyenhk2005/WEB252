<?php
// Helper: delete this file after running
$files = [
    __DIR__ . '/views/client/contact.php',
    __DIR__ . '/views/admin/contacts/index.php',
    __DIR__ . '/views/admin/settings/index.php',
    __DIR__ . '/views/admin/users/index.php',
];

$csrfField = '<?= csrf_field() ?>';

foreach ($files as $file) {
    $content = file_get_contents($file);
    // Add csrf_field() after every <form ... > opening tag that doesn't already have it
    $content = preg_replace_callback(
        '/(<form\b[^>]*>)(?!\s*<\?=\s*csrf_field)/s',
        function($m) use ($csrfField) {
            return $m[1] . "\n                            " . $csrfField;
        },
        $content
    );
    file_put_contents($file, $content);
    echo "✅ Patched: $file\n";
}
echo "\nDone. Delete this file (patch_csrf.php) now.\n";
