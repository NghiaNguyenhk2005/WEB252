<?php
define('BASE_PATH', '/WEB252');
session_start();

// Load SEO class
require_once __DIR__ . '/app/core/SEO.php';

// Test different page types
$testPages = [
    'home' => [
        'title' => 'TechSaaS - Giải pháp Doanh nghiệp',
        'description' => 'Nền tảng cung cấp giải pháp công nghệ tối ưu cho doanh nghiệp',
    ],
    'product' => [
        'title' => 'Sản phẩm A - TechSaaS',
        'description' => 'Mô tả sản phẩm A chất lượng cao',
    ],
    'post' => [
        'title' => 'Bài viết mới - TechSaaS',
        'description' => 'Nội dung bài viết mới nhất',
    ],
];

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>SEO Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .test-card { background: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .test-card h3 { color: #4e73df; margin-top: 0; }
        .pass { color: green; font-weight: bold; }
        .fail { color: red; font-weight: bold; }
        pre { background: #f0f0f0; padding: 10px; border-radius: 5px; overflow-x: auto; }
        code { font-family: monospace; }
    </style>
</head>
<body>
    <h1>SEO Implementation Test</h1>";

// Test each page type
foreach ($testPages as $type => $data) {
    echo "<div class='test-card'>
        <h3>Testing: " . ucfirst($type) . " Page</h3>";
    
    // Set SEO
    SEO::set('title', $data['title'])
        ->set('description', $data['description'])
        ->set('keywords', 'test, seo, techsaas')
        ->set('og_image', BASE_PATH . '/assets/client/img/og-image.jpg');
    
    // Render SEO
    $seoHTML = SEO::render();
    
    echo "<p><strong>Generated SEO HTML:</strong></p>";
    echo "<pre><code>" . htmlspecialchars($seoHTML) . "</code></pre>";
    
    // Validate
    $checks = [];
    $checks[] = strpos($seoHTML, $data['title']) !== false;
    $checks[] = strpos($seoHTML, $data['description']) !== false;
    $checks[] = strpos($seoHTML, 'og:title') !== false;
    $checks[] = strpos($seoHTML, 'og:description') !== false;
    $checks[] = strpos($seoHTML, 'canonical') !== false;
    
    echo "<p><strong>Validation Results:</strong></p>";
    echo "<ul>";
    echo "<li>Title tag present: " . ($checks[0] ? "<span class='pass'>✓ PASS</span>" : "<span class='fail'>✗ FAIL</span>") . "</li>";
    echo "<li>Description tag present: " . ($checks[1] ? "<span class='pass'>✓ PASS</span>" : "<span class='fail'>✗ FAIL</span>") . "</li>";
    echo "<li>Open Graph title: " . ($checks[2] ? "<span class='pass'>✓ PASS</span>" : "<span class='fail'>✗ FAIL</span>") . "</li>";
    echo "<li>Open Graph description: " . ($checks[3] ? "<span class='pass'>✓ PASS</span>" : "<span class='fail'>✗ FAIL</span>") . "</li>";
    echo "<li>Canonical URL: " . ($checks[4] ? "<span class='pass'>✓ PASS</span>" : "<span class='fail'>✗ FAIL</span>") . "</li>";
    echo "</ul>";
    
    echo "</div>";
}

echo "</body></html>";
?>