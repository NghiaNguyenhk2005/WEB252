<?php

class SEO {
    private static $defaultMeta = [
        'title' => 'TechSaaS - Giải pháp công nghệ cho doanh nghiệp',
        'description' => 'Nền tảng cung cấp giải pháp công nghệ tối ưu cho doanh nghiệp vừa và nhỏ tại Việt Nam.',
        'keywords' => 'techsaas, giải pháp công nghệ, doanh nghiệp, SaaS, Việt Nam',
        'author' => 'TechSaaS',
        'og_image' => '/assets/client/img/og-image.jpg',
        'og_type' => 'website'
    ];
    
    private static $currentMeta = [];
    
    public static function set($key, $value) {
        self::$currentMeta[$key] = $value;
        return new self();
    }
    
    public static function get($key) {
        return self::$currentMeta[$key] ?? self::$defaultMeta[$key] ?? '';
    }
    public static function render() {
        $title = self::get('title');
        $description = self::get('description');
        $keywords = self::get('keywords');
        $author = self::get('author');
        $ogImage = self::get('og_image');
        $ogType = self::get('og_type');
        $robots = self::get('robots');
        
        // Fix: Properly generate current URL
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $currentUrl = $protocol . '://' . $host . $uri;
        
        $canonical = self::get('canonical');
        if (empty($canonical)) {
            $canonical = $currentUrl;
        }
        
        $html = <<<HTML
        <title>{$title}</title>
        <meta name="description" content="{$description}">
        <meta name="keywords" content="{$keywords}">
        <meta name="author" content="{$author}">
        <meta name="robots" content="{$robots}">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="{$ogType}">
        <meta property="og:url" content="{$canonical}">
        <meta property="og:title" content="{$title}">
        <meta property="og:description" content="{$description}">
        <meta property="og:image" content="{$ogImage}">
        
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{$title}">
        <meta name="twitter:description" content="{$description}">
        <meta name="twitter:image" content="{$ogImage}">
        
        <!-- Canonical URL -->
        <link rel="canonical" href="{$canonical}">
        HTML;
        
        return $html;
    }
}
?>