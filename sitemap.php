<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/core/Database.php';

$db = new Database();
$conn = $db->getConnection();

header('Content-Type: application/xml; charset=utf-8');

$urls = [];

// Homepage
$urls[] = [
    'loc' => BASE_PATH . '/',
    'priority' => '1.0',
    'changefreq' => 'daily'
];

// Products
$products = $conn->query("SELECT slug, updated_at FROM products WHERE deleted_at IS NULL");
while ($product = $products->fetch_assoc()) {
    $urls[] = [
        'loc' => BASE_PATH . '/product/' . $product['slug'],
        'priority' => '0.8',
        'changefreq' => 'weekly',
        'lastmod' => $product['updated_at']
    ];
}

// Posts
$posts = $conn->query("SELECT slug, created_at FROM posts WHERE status = 1");
while ($post = $posts->fetch_assoc()) {
    $urls[] = [
        'loc' => BASE_PATH . '/news/' . $post['slug'],
        'priority' => '0.7',
        'changefreq' => 'weekly',
        'lastmod' => $post['created_at']
    ];
}

// Static pages
$staticPages = ['products', 'news', 'services', 'faqs', 'contact', 'about'];
foreach ($staticPages as $page) {
    $urls[] = [
        'loc' => BASE_PATH . '/' . $page,
        'priority' => '0.6',
        'changefreq' => 'monthly'
    ];
}

// Generate XML
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

foreach ($urls as $url) {
    echo '<url>';
    echo '<loc>' . htmlspecialchars($url['loc']) . '</loc>';
    if (isset($url['lastmod']) && $url['lastmod']) {
        echo '<lastmod>' . date('Y-m-d', strtotime($url['lastmod'])) . '</lastmod>';
    }
    echo '<changefreq>' . $url['changefreq'] . '</changefreq>';
    echo '<priority>' . $url['priority'] . '</priority>';
    echo '</url>';
}

echo '</urlset>';
?>