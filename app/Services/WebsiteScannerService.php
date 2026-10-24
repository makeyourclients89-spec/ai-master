<?php

namespace App\Services;

class WebsiteScannerService
{
    /**
     * Scan a website URL and extract comprehensive digital marketing & technical details.
     *
     * @param string $url
     * @return array
     */
    public function scan(string $url): array
    {
        $url = trim($url);
        if (!preg_match('~^(?:f|ht)tps?://~i', $url)) {
            $url = 'https://' . $url;
        }

        $parsedUrl = parse_url($url);
        $scheme = $parsedUrl['scheme'] ?? 'https';
        $host = $parsedUrl['host'] ?? '';
        $baseUrl = $scheme . '://' . $host;

        // 1. Fetch Homepage Content with Timing
        $startTime = microtime(true);
        $fetchResult = $this->fetchUrl($url);
        $totalTimeMs = round((microtime(true) - $startTime) * 1000);

        if (!$fetchResult['success']) {
            return [
                'success'          => false,
                'url'              => $url,
                'status_code'      => $fetchResult['status_code'] ?? 0,
                'response_time_ms' => $totalTimeMs,
                'error'            => $fetchResult['error'] ?? 'Connection failed',
                'scanned_at'       => date('Y-m-d H:i:s'),
                'seo_score'        => 0,
            ];
        }

        $html = $fetchResult['body'];
        $headers = $fetchResult['headers'];
        $statusCode = $fetchResult['status_code'];
        $effectiveUrl = $fetchResult['effective_url'] ?: $url;

        // 2. Parse SEO & Head Tags
        $seo = $this->extractSeoTags($html, $effectiveUrl);

        // 3. Detect CMS, Platforms & Tech Stack
        $tech = $this->detectTechStack($html, $headers);

        // 4. Detect Tracking, Pixels & Analytics
        $tracking = $this->detectTrackingPixels($html);

        // 5. Detect Contact Information & Social Links
        $contacts = $this->extractContactAndSocial($html, $baseUrl);

        // 6. Check Robots.txt & Sitemap.xml
        $sitemapInfo = $this->checkRobotsAndSitemap($baseUrl);

        // 7. Calculate SEO Health Score (0-100)
        $score = $this->calculateSeoScore($seo, $sitemapInfo, $statusCode, $totalTimeMs);

        // 8. Measure Mobile & Desktop Speed
        $speed = $this->measurePageSpeed($url, $totalTimeMs, $html);

        // 9. Generate Summary & Actionable Agency Insights
        $insights = $this->generateInsights($seo, $tech, $tracking, $contacts, $sitemapInfo);

        return [
            'success'          => true,
            'url'              => $url,
            'effective_url'    => $effectiveUrl,
            'status_code'      => $statusCode,
            'response_time_ms' => $totalTimeMs,
            'is_https'         => strpos($effectiveUrl, 'https://') === 0,
            'server'           => $headers['server'] ?? ($headers['Server'] ?? 'Unknown'),
            'scanned_at'       => date('Y-m-d H:i:s'),
            'seo_score'        => $score,
            'cms_platform'     => $tech['platform_name'],
            'speed'            => $speed,
            'seo'              => $seo,
            'tech'             => $tech,
            'tracking'         => $tracking,
            'contacts'         => $contacts,
            'sitemap_robots'   => $sitemapInfo,
            'insights'         => $insights,
        ];
    }

    /**
     * cURL Fetch with headers and timing
     */
    protected function fetchUrl(string $url): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
        curl_setopt($ch, CURLOPT_TIMEOUT, 12);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 6);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 AI-Agency-Auditor/2.0');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);

        if ($response === false || empty($response)) {
            return [
                'success'     => false,
                'status_code' => $statusCode,
                'error'       => $error ?: 'Unable to connect to website URL',
            ];
        }

        $headerText = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);

        // Parse headers into array
        $headers = [];
        foreach (explode("\r\n", $headerText) as $line) {
            $parts = explode(':', $line, 2);
            if (count($parts) === 2) {
                $headers[trim(strtolower($parts[0]))] = trim($parts[1]);
            }
        }

        return [
            'success'       => true,
            'status_code'   => $statusCode,
            'effective_url' => $effectiveUrl,
            'headers'       => $headers,
            'body'          => $body,
        ];
    }

    /**
     * Extract SEO meta tags, title, OG tags, Headings
     */
    protected function extractSeoTags(string $html, string $effectiveUrl): array
    {
        $seo = [
            'title'            => '',
            'title_length'     => 0,
            'description'      => '',
            'description_len'  => 0,
            'keywords'         => '',
            'canonical'        => '',
            'favicon'          => '',
            'og'               => [],
            'twitter'          => [],
            'h1_tags'          => [],
            'h2_tags'          => [],
            'images_total'     => 0,
            'images_no_alt'    => 0,
            'word_count'       => 0,
            'google_verify'    => '',
        ];

        // Title
        if (preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $matches)) {
            $seo['title'] = html_entity_decode(trim($matches[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $seo['title_length'] = mb_strlen($seo['title']);
        }

        // Meta tags
        if (preg_match_all('/<meta\s+([^>]+)>/is', $html, $matches)) {
            foreach ($matches[1] as $metaAttrs) {
                $name = '';
                $content = '';
                $property = '';

                if (preg_match('/name=["\']([^"\']+)["\']/i', $metaAttrs, $m)) $name = strtolower($m[1]);
                if (preg_match('/property=["\']([^"\']+)["\']/i', $metaAttrs, $m)) $property = strtolower($m[1]);
                if (preg_match('/content=["\']([^"\']*)["\']/i', $metaAttrs, $m)) $content = html_entity_decode(trim($m[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8');

                if ($name === 'description') {
                    $seo['description'] = $content;
                    $seo['description_len'] = mb_strlen($content);
                } elseif ($name === 'keywords') {
                    $seo['keywords'] = $content;
                } elseif ($name === 'google-site-verification') {
                    $seo['google_verify'] = $content;
                }

                // Open Graph
                if (strpos($property, 'og:') === 0) {
                    $ogKey = substr($property, 3);
                    $seo['og'][$ogKey] = $content;
                }

                // Twitter
                if (strpos($name, 'twitter:') === 0) {
                    $twKey = substr($name, 8);
                    $seo['twitter'][$twKey] = $content;
                }
            }
        }

        // Canonical
        if (preg_match('/<link[^>]+rel=["\']canonical["\'][^>]+href=["\']([^"\']+)["\']/is', $html, $m)) {
            $seo['canonical'] = $m[1];
        } elseif (preg_match('/<link[^>]+href=["\']([^"\']+)["\'][^>]+rel=["\']canonical["\']/is', $html, $m)) {
            $seo['canonical'] = $m[1];
        }

        // Favicon
        if (preg_match('/<link[^>]+rel=["\'](?:shortcut\s+)?icon["\'][^>]+href=["\']([^"\']+)["\']/is', $html, $m)) {
            $fav = $m[1];
            if (strpos($fav, '//') === 0) {
                $fav = 'https:' . $fav;
            } elseif (strpos($fav, 'http') !== 0) {
                $fav = rtrim($effectiveUrl, '/') . '/' . ltrim($fav, '/');
            }
            $seo['favicon'] = $fav;
        }

        // H1 Headings
        if (preg_match_all('/<h1[^>]*>(.*?)<\/h1>/is', $html, $m)) {
            foreach ($m[1] as $h1) {
                $clean = trim(strip_tags($h1));
                if (!empty($clean)) {
                    $seo['h1_tags'][] = html_entity_decode($clean, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                }
            }
        }

        // H2 Headings (top 6)
        if (preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', $html, $m)) {
            $count = 0;
            foreach ($m[1] as $h2) {
                $clean = trim(strip_tags($h2));
                if (!empty($clean) && $count < 6) {
                    $seo['h2_tags'][] = html_entity_decode($clean, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $count++;
                }
            }
        }

        // Images count & Alt check
        if (preg_match_all('/<img\s+([^>]+)>/is', $html, $m)) {
            $seo['images_total'] = count($m[0]);
            foreach ($m[1] as $imgAttrs) {
                if (!preg_match('/alt=["\'][^"\']+["\']/i', $imgAttrs)) {
                    $seo['images_no_alt']++;
                }
            }
        }

        // Approximate Word Count
        $plainText = preg_replace('/<(script|style|svg|noscript)\b[^>]*>(.*?)<\/\1>/is', '', $html);
        $plainText = strip_tags($plainText);
        $plainText = preg_replace('/\s+/', ' ', $plainText);
        $seo['word_count'] = str_word_count($plainText);

        return $seo;
    }

    /**
     * Detect CMS Platform, Themes & Server Tech
     */
    protected function detectTechStack(string $html, array $headers): array
    {
        $tech = [
            'platform'      => 'custom',
            'platform_name' => 'Custom Web Stack / HTML5',
            'cms_signals'   => [],
            'theme_plugins' => [],
            'frameworks'    => [],
            'server_stack'  => [],
        ];

        $lowerHtml = strtolower($html);

        // Server Detection
        if (!empty($headers['server'])) {
            $tech['server_stack'][] = $headers['server'];
        }
        if (!empty($headers['cf-ray']) || !empty($headers['cf-cache-status'])) {
            $tech['server_stack'][] = 'Cloudflare CDN & WAF';
        }
        if (!empty($headers['x-litespeed-cache']) || !empty($headers['x-litespeed-tag'])) {
            $tech['server_stack'][] = 'LiteSpeed Enterprise Web Server';
        }

        // WordPress & WooCommerce
        $isWp = strpos($lowerHtml, 'wp-content') !== false || strpos($lowerHtml, 'wp-includes') !== false;
        $isWoo = strpos($lowerHtml, 'woocommerce') !== false || strpos($lowerHtml, 'wc-cart') !== false;

        if ($isWoo) {
            $tech['platform'] = 'woocommerce';
            $tech['platform_name'] = 'WordPress + WooCommerce E-Commerce';
            $tech['cms_signals'][] = 'WooCommerce Cart & Product Engine';
        } elseif ($isWp) {
            $tech['platform'] = 'wordpress';
            $tech['platform_name'] = 'WordPress CMS';
            $tech['cms_signals'][] = 'WordPress Theme & Core Framework';
        } elseif (strpos($lowerHtml, 'cdn.shopify.com') !== false || strpos($lowerHtml, 'shopify.theme') !== false) {
            $tech['platform'] = 'shopify';
            $tech['platform_name'] = 'Shopify E-Commerce Store';
            $tech['cms_signals'][] = 'Shopify Liquid Engine & CDN';
        } elseif (strpos($lowerHtml, 'webflow.com') !== false || strpos($lowerHtml, 'data-wf-page') !== false) {
            $tech['platform'] = 'webflow';
            $tech['platform_name'] = 'Webflow Visual Builder';
            $tech['cms_signals'][] = 'Webflow Responsive Framework';
        } elseif (strpos($lowerHtml, 'wix.com') !== false || strpos($lowerHtml, '_wix_') !== false) {
            $tech['platform'] = 'wix';
            $tech['platform_name'] = 'Wix Website Builder';
            $tech['cms_signals'][] = 'Wix Cloud Engine';
        } elseif (strpos($lowerHtml, '__next_data__') !== false || strpos($lowerHtml, '/_next/static/') !== false) {
            $tech['platform'] = 'nextjs';
            $tech['platform_name'] = 'Next.js / React SSR Application';
            $tech['cms_signals'][] = 'Next.js JavaScript Framework';
        }

        // Themes & Plugins detection
        if (preg_match('/wp-content\/themes\/([a-zA-Z0-9_\-]+)/i', $html, $m)) {
            $tech['theme_plugins'][] = 'Theme: ' . ucfirst($m[1]);
        }
        if (strpos($lowerHtml, 'elementor') !== false) {
            $tech['theme_plugins'][] = 'Elementor Page Builder';
        }
        if (strpos($lowerHtml, 'yoast') !== false) {
            $tech['theme_plugins'][] = 'Yoast SEO Plugin';
        }
        if (strpos($lowerHtml, 'rankmath') !== false) {
            $tech['theme_plugins'][] = 'RankMath SEO Suite';
        }

        // Frameworks
        if (strpos($lowerHtml, 'bootstrap') !== false) $tech['frameworks'][] = 'Bootstrap CSS';
        if (strpos($lowerHtml, 'tailwind') !== false) $tech['frameworks'][] = 'Tailwind CSS';
        if (strpos($lowerHtml, 'jquery') !== false) $tech['frameworks'][] = 'jQuery Library';
        if (strpos($lowerHtml, 'swiper') !== false) $tech['frameworks'][] = 'Swiper Carousel';

        return $tech;
    }

    /**
     * Detect Tracking Pixels, Tags & Analytics
     */
    protected function detectTrackingPixels(string $html): array
    {
        $tracking = [
            'gtm'         => ['detected' => false, 'id' => null],
            'ga4'         => ['detected' => false, 'id' => null],
            'meta_pixel'  => ['detected' => false, 'id' => null],
            'google_ads'  => ['detected' => false, 'id' => null],
            'clarity'     => ['detected' => false, 'id' => null],
            'hotjar'      => ['detected' => false, 'id' => null],
            'tiktok'      => ['detected' => false, 'id' => null],
            'klaviyo'     => ['detected' => false, 'id' => null],
            'hubspot'     => ['detected' => false, 'id' => null],
        ];

        // GTM
        if (preg_match('/GTM-[A-Z0-9]+/i', $html, $m)) {
            $tracking['gtm'] = ['detected' => true, 'id' => $m[0]];
        }

        // GA4 (Measurement ID format G-XXXXXXXXXX)
        if (preg_match('/(?:gtag\s*\(\s*[\'"]config[\'"]\s*,\s*[\'"]|["\'])(G-[A-Z0-9]{8,12})[\'"]/i', $html, $m)) {
            $tracking['ga4'] = ['detected' => true, 'id' => strtoupper($m[1])];
        } elseif (preg_match('/\bUA-[0-9]+-[0-9]+\b/i', $html, $m)) {
            $tracking['ga4'] = ['detected' => true, 'id' => strtoupper($m[0]) . ' (UA)'];
        }

        // Meta Pixel
        if (preg_match('/fbq\s*\(\s*[\'"]init[\'"]\s*,\s*[\'"]([0-9]{12,18})[\'"]/i', $html, $m)) {
            $tracking['meta_pixel'] = ['detected' => true, 'id' => $m[1]];
        } elseif (strpos($html, 'connect.facebook.net') !== false || strpos($html, 'fbevents.js') !== false) {
            $tracking['meta_pixel'] = ['detected' => true, 'id' => 'Active'];
        }

        // Google Ads Conversion Tag
        if (preg_match('/AW-[0-9]+/i', $html, $m)) {
            $tracking['google_ads'] = ['detected' => true, 'id' => $m[0]];
        }

        // Microsoft Clarity
        if (strpos($html, 'clarity.ms') !== false || preg_match('/clarity\s*\(\s*["\']([a-z0-9]{8,12})["\']/i', $html, $m)) {
            $tracking['clarity'] = ['detected' => true, 'id' => $m[1] ?? 'Active'];
        }

        // Hotjar
        if (strpos($html, 'static.hotjar.com') !== false || preg_match('/hjid:\s*([0-9]+)/i', $html, $m)) {
            $tracking['hotjar'] = ['detected' => true, 'id' => $m[1] ?? 'Active'];
        }

        // TikTok Pixel
        if (strpos($html, 'analytics.tiktok.com') !== false || preg_match('/ttq\.load\([\'"]([A-Z0-9]+)[\'"]\)/i', $html, $m)) {
            $tracking['tiktok'] = ['detected' => true, 'id' => $m[1] ?? 'Active'];
        }

        // Klaviyo
        if (strpos($html, 'static.klaviyo.com') !== false) {
            $tracking['klaviyo'] = ['detected' => true, 'id' => 'Active'];
        }

        // HubSpot
        if (strpos($html, 'js.hs-scripts.com') !== false) {
            $tracking['hubspot'] = ['detected' => true, 'id' => 'Active'];
        }

        return $tracking;
    }

    /**
     * Extract Phone Numbers, Emails, Social Media links
     */
    protected function extractContactAndSocial(string $html, string $baseUrl): array
    {
        $contacts = [
            'emails'   => [],
            'phones'   => [],
            'whatsapp' => '',
            'social'   => [
                'facebook'  => null,
                'instagram' => null,
                'twitter'   => null,
                'linkedin'  => null,
                'youtube'   => null,
                'pinterest' => null,
                'whatsapp'  => null,
                'tiktok'    => null,
                'github'    => null,
            ],
        ];

        // Mailto
        if (preg_match_all('/mailto:([a-zA-Z0-9_\.\-]+@[a-zA-Z0-9_\.\-]+\.[a-zA-Z]{2,6})/i', $html, $m)) {
            $contacts['emails'] = array_values(array_unique(array_map('strtolower', $m[1])));
        }

        // Tel links
        if (preg_match_all('/tel:([+0-9\s\-()]{7,20})/i', $html, $m)) {
            $contacts['phones'] = array_values(array_unique(array_map('trim', $m[1])));
        }

        // WhatsApp links (wa.me/xxx or api.whatsapp.com/send?phone=xxx)
        if (preg_match('/(?:https?:\/\/)?(?:wa\.me\/|api\.whatsapp\.com\/send\?(?:[^"\'\s]*&)?phone=)([0-9+]+)/i', $html, $m)) {
            $cleanWa = '+' . ltrim($m[1], '+');
            $contacts['whatsapp'] = $cleanWa;
            $contacts['social']['whatsapp'] = 'https://wa.me/' . ltrim($cleanWa, '+');
        }

        // Social handles
        if (preg_match('/https?:\/\/(?:www\.)?facebook\.com\/([a-zA-Z0-9._\-]+)/i', $html, $m)) {
            if ($m[1] !== 'sharer' && $m[1] !== 'tr') $contacts['social']['facebook'] = 'https://facebook.com/' . $m[1];
        }
        if (preg_match('/https?:\/\/(?:www\.)?instagram\.com\/([a-zA-Z0-9._\-]+)/i', $html, $m)) {
            $contacts['social']['instagram'] = 'https://instagram.com/' . $m[1];
        }
        if (preg_match('/https?:\/\/(?:www\.)?(?:twitter\.com|x\.com)\/([a-zA-Z0-9._\-]+)/i', $html, $m)) {
            if ($m[1] !== 'share' && $m[1] !== 'intent') $contacts['social']['twitter'] = 'https://x.com/' . $m[1];
        }
        if (preg_match('/https?:\/\/(?:www\.)?linkedin\.com\/(?:company|in)\/([a-zA-Z0-9._\-]+)/i', $html, $m)) {
            $contacts['social']['linkedin'] = 'https://linkedin.com/company/' . $m[1];
        }
        if (preg_match('/https?:\/\/(?:www\.)?youtube\.com\/(?:@|channel\/|c\/|user\/)?([a-zA-Z0-9._\-]+)/i', $html, $m)) {
            $contacts['social']['youtube'] = 'https://youtube.com/@' . $m[1];
        }
        if (preg_match('/https?:\/\/(?:www\.)?pinterest\.(?:com|[a-z]{2,3})\/([a-zA-Z0-9._\-]+)/i', $html, $m)) {
            if (!in_array(strtolower($m[1]), ['pin', 'search', 'today', 'business'])) {
                $contacts['social']['pinterest'] = 'https://pinterest.com/' . $m[1];
            }
        }
        if (preg_match('/https?:\/\/(?:www\.)?tiktok\.com\/@([a-zA-Z0-9._\-]+)/i', $html, $m)) {
            $contacts['social']['tiktok'] = 'https://tiktok.com/@' . $m[1];
        }
        if (preg_match('/https?:\/\/(?:www\.)?github\.com\/([a-zA-Z0-9._\-]+)/i', $html, $m)) {
            if (!in_array(strtolower($m[1]), ['features', 'pricing', 'enterprise'])) {
                $contacts['social']['github'] = 'https://github.com/' . $m[1];
            }
        }

        return $contacts;
    }

    /**
     * Measure Mobile and Desktop Page Speed & Core Metrics
     */
    protected function measurePageSpeed(string $url, int $desktopTimeMs, string $html): array
    {
        // 1. Rapid Mobile Crawl with iPhone / Android User-Agent
        $mobileStartTime = microtime(true);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Mobile/15E148 Safari/604.1');
        $mobileRes = curl_exec($ch);
        $mobileTotalTimeMs = round((microtime(true) - $mobileStartTime) * 1000);
        $mobileHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!$mobileRes || $mobileHttpCode < 200 || $mobileHttpCode >= 400) {
            $mobileTotalTimeMs = max(320, round($desktopTimeMs * 1.25));
        }

        // Viewport check
        $hasViewport = (bool)preg_match('/<meta[^>]+name=["\']viewport["\'][^>]*>/i', $html);
        $hasDeviceWidth = (bool)preg_match('/content=["\'][^"\']*width=device-width/i', $html);

        // Scripts, Styles & Payload weight
        $scriptCount = preg_match_all('/<script\b/i', $html, $sm);
        $styleCount = preg_match_all('/<link[^>]+rel=["\']stylesheet["\']/i', $html, $sm2);
        $payloadKb = round(strlen($html) / 1024, 1);

        // Desktop Score Calculation
        $desktopScore = 100;
        if ($desktopTimeMs > 1500) $desktopScore -= 25;
        elseif ($desktopTimeMs > 800) $desktopScore -= 15;
        elseif ($desktopTimeMs > 450) $desktopScore -= 8;
        elseif ($desktopTimeMs > 250) $desktopScore -= 3;

        if ($payloadKb > 250) $desktopScore -= 8;
        elseif ($payloadKb > 150) $desktopScore -= 4;

        if ($scriptCount > 35) $desktopScore -= 6;
        $desktopScore = max(45, min(99, $desktopScore));

        // Mobile Score Calculation
        $mobileScore = 96;
        if ($mobileTotalTimeMs > 1600) $mobileScore -= 26;
        elseif ($mobileTotalTimeMs > 900) $mobileScore -= 16;
        elseif ($mobileTotalTimeMs > 500) $mobileScore -= 9;
        elseif ($mobileTotalTimeMs > 300) $mobileScore -= 4;

        if (!$hasViewport || !$hasDeviceWidth) $mobileScore -= 20;
        if ($payloadKb > 180) $mobileScore -= 8;
        if ($scriptCount > 30) $mobileScore -= 6;
        $mobileScore = max(40, min(98, $mobileScore));

        // Estimated Speed Metrics
        $desktopFcp = sprintf('%.1fs', max(0.4, round($desktopTimeMs * 1.2) / 1000));
        $desktopLcp = sprintf('%.1fs', max(0.8, round($desktopTimeMs * 2.0) / 1000));
        $mobileFcp  = sprintf('%.1fs', max(0.8, round($mobileTotalTimeMs * 1.5) / 1000));
        $mobileLcp  = sprintf('%.1fs', max(1.3, round($mobileTotalTimeMs * 2.6) / 1000));

        return [
            'desktop' => [
                'score'            => $desktopScore,
                'response_time_ms' => $desktopTimeMs,
                'rating'           => $desktopScore >= 90 ? 'Optimal' : ($desktopScore >= 75 ? 'Good' : 'Needs Work'),
                'fcp'              => $desktopFcp,
                'lcp'              => $desktopLcp,
                'payload_kb'       => $payloadKb,
                'scripts_count'    => $scriptCount,
            ],
            'mobile' => [
                'score'            => $mobileScore,
                'response_time_ms' => $mobileTotalTimeMs,
                'rating'           => $mobileScore >= 85 ? 'Fast' : ($mobileScore >= 70 ? 'Good' : 'Needs Work'),
                'fcp'              => $mobileFcp,
                'lcp'              => $mobileLcp,
                'viewport_ready'   => $hasViewport && $hasDeviceWidth,
                'mobile_friendly'  => $hasViewport && $hasDeviceWidth,
            ],
        ];
    }

    /**
     * Check Robots.txt and Sitemap.xml availability
     */
    protected function checkRobotsAndSitemap(string $baseUrl): array
    {
        $info = [
            'robots_found'  => false,
            'robots_url'    => rtrim($baseUrl, '/') . '/robots.txt',
            'sitemap_found' => false,
            'sitemap_url'   => rtrim($baseUrl, '/') . '/sitemap.xml',
        ];

        // Check Robots
        $ch = curl_init($info['robots_url']);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($code >= 200 && $code < 400) {
            $info['robots_found'] = true;
        }

        // Check Sitemap
        $ch = curl_init($info['sitemap_url']);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($code >= 200 && $code < 400) {
            $info['sitemap_found'] = true;
        }

        return $info;
    }

    /**
     * Calculate SEO & Performance Score (0-100)
     */
    protected function calculateSeoScore(array $seo, array $sitemap, int $statusCode, int $latencyMs): int
    {
        $score = 0;

        if ($statusCode === 200) $score += 15;
        if (!empty($seo['title'])) $score += 15;
        if (!empty($seo['description'])) $score += 15;
        if (!empty($seo['h1_tags'])) $score += 10;
        if (!empty($seo['canonical'])) $score += 10;
        if (!empty($seo['og']['title']) || !empty($seo['og']['image'])) $score += 10;
        if ($sitemap['robots_found']) $score += 10;
        if ($sitemap['sitemap_found']) $score += 10;
        if ($latencyMs < 1500) $score += 5;

        return min(100, max(10, $score));
    }

    /**
     * Generate Actionable Insights for Digital Marketers
     */
    protected function generateInsights(array $seo, array $tech, array $tracking, array $contacts, array $sitemap): array
    {
        $insights = [];

        // Meta Description
        if (empty($seo['description'])) {
            $insights[] = [
                'type'    => 'warning',
                'title'   => 'Meta Description Missing',
                'message' => 'Homepage me meta description tag nahi mila. Search snippets click-through-rate improve karne ke liye description zaroori hai.',
            ];
        } else {
            $insights[] = [
                'type'    => 'success',
                'title'   => 'Meta Description Active (' . $seo['description_len'] . ' chars)',
                'message' => 'Search engines ke liye compelling snippet set hai.',
            ];
        }

        // H1 tag
        if (empty($seo['h1_tags'])) {
            $insights[] = [
                'type'    => 'warning',
                'title'   => 'H1 Heading Missing',
                'message' => 'Page par koi main <h1> heading nahi mili. Primary target keyword ke sath H1 tag add karein.',
            ];
        } else {
            $insights[] = [
                'type'    => 'success',
                'title'   => count($seo['h1_tags']) . ' H1 Tag(s) Found',
                'message' => 'Primary Heading: "' . substr($seo['h1_tags'][0], 0, 70) . '..."',
            ];
        }

        // Analytics & Tracking
        if (!$tracking['ga4']['detected'] && !$tracking['gtm']['detected']) {
            $insights[] = [
                'type'    => 'danger',
                'title'   => 'GA4 / Google Tag Manager Missing',
                'message' => 'Website par GA4 ya GTM tag nahi mila. Traffic aur conversions measure karne ke liye GTM connector connect karein.',
            ];
        } else {
            $trackerName = $tracking['gtm']['detected'] ? 'Google Tag Manager (' . $tracking['gtm']['id'] . ')' : 'Google Analytics 4';
            $insights[] = [
                'type'    => 'success',
                'title'   => $trackerName . ' Active',
                'message' => 'Tracking code website par live hai.',
            ];
        }

        // Meta Ads Pixel
        if (!$tracking['meta_pixel']['detected']) {
            $insights[] = [
                'type'    => 'info',
                'title'   => 'Meta Pixel Not Found',
                'message' => 'Agar Meta Ads ya remarketing chalani hai toh Meta Conversions API (CAPI) connector connect karein.',
            ];
        } else {
            $insights[] = [
                'type'    => 'success',
                'title'   => 'Meta Pixel Active',
                'message' => 'Remarketing aur conversion events track ho rahe hain.',
            ];
        }

        // Platform
        $insights[] = [
            'type'    => 'info',
            'title'   => 'Platform: ' . $tech['platform_name'],
            'message' => !empty($tech['theme_plugins']) ? 'Detected: ' . implode(', ', $tech['theme_plugins']) : 'Standard optimized architecture.',
        ];

        return $insights;
    }
}
