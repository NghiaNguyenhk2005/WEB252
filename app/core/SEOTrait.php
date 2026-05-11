<?php

trait SEOTrait {
    
    protected function setPageSEO($page, $data = null) {
        global $globalSettings;
        
        $seoConfig = [
            // ... existing configs ...
            'services' => [
                'title' => 'Dịch vụ - ' . ($globalSettings['site_name'] ?? 'TechSaaS'),
                'description' => 'Dịch vụ tư vấn và triển khai giải pháp công nghệ chuyên nghiệp cho doanh nghiệp.',
                'keywords' => 'dịch vụ công nghệ, tư vấn SaaS, triển khai hệ thống, giải pháp doanh nghiệp',
            ],
            'service' => [
                'title' => ($data['name'] ?? 'Dịch vụ') . ' - ' . ($globalSettings['site_name'] ?? 'TechSaaS'),
                'description' => mb_substr(strip_tags($data['short_description'] ?? ''), 0, 160),
                'keywords' => ($data['name'] ?? '') . ', dịch vụ, tư vấn, giải pháp công nghệ',
            ],
            'faqs' => [
                'title' => 'Câu hỏi thường gặp - ' . ($globalSettings['site_name'] ?? 'TechSaaS'),
                'description' => 'Giải đáp thắc mắc về sản phẩm, dịch vụ và chính sách của chúng tôi.',
                'keywords' => 'faq, câu hỏi thường gặp, hỗ trợ khách hàng, thắc mắc',
            ],
            'contact' => [
                'title' => 'Liên hệ - ' . ($globalSettings['site_name'] ?? 'TechSaaS'),
                'description' => 'Liên hệ với chúng tôi để được tư vấn và hỗ trợ giải pháp công nghệ tốt nhất.',
                'keywords' => 'liên hệ, tư vấn, hỗ trợ, email, phone, địa chỉ',
            ],
            'about' => [
                'title' => 'Về chúng tôi - ' . ($globalSettings['site_name'] ?? 'TechSaaS'),
                'description' => 'Tìm hiểu về sứ mệnh, tầm nhìn và giá trị cốt lõi của ' . ($globalSettings['site_name'] ?? 'TechSaaS'),
                'keywords' => 'giới thiệu, về chúng tôi, công ty, sứ mệnh, tầm nhìn, giá trị',
            ],
        ];
        
        if (isset($seoConfig[$page])) {
            $config = $seoConfig[$page];
            SEO::set('title', $config['title']);
            SEO::set('description', $config['description']);
            SEO::set('keywords', $config['keywords']);
            if (isset($config['og_type'])) {
                SEO::set('og_type', $config['og_type']);
            }
            if (isset($data['slug'])) {
                SEO::set('canonical', BASE_PATH . '/' . $page . '/' . $data['slug']);
            }
        }
        
        return $this;
    }
}