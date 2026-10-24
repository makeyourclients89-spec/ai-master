<?php

if (!function_exists('get_agency_services')) {
    /**
     * Returns standard agency services/departments list requested:
     * Website, SEO, AEO, GEO, SMO, PPC, Meta Ads, Mobile Application, Custom Software
     */
    function get_agency_services(): array
    {
        return [
            'Website'            => ['label' => 'Website', 'icon' => 'globe', 'color' => 'emerald', 'desc' => 'Website Design & Development'],
            'SEO'                => ['label' => 'SEO', 'icon' => 'search', 'color' => 'indigo', 'desc' => 'Search Engine Optimization'],
            'AEO'                => ['label' => 'AEO', 'icon' => 'bot', 'color' => 'purple', 'desc' => 'Answer Engine Optimization (AI Search)'],
            'GEO'                => ['label' => 'GEO', 'icon' => 'sparkles', 'color' => 'fuchsia', 'desc' => 'Generative Engine Optimization'],
            'SMO'                => ['label' => 'SMO', 'icon' => 'share-2', 'color' => 'pink', 'desc' => 'Social Media Optimization & Viral Growth'],
            'PPC'                => ['label' => 'PPC', 'icon' => 'target', 'color' => 'amber', 'desc' => 'Pay-Per-Click & Google Ads'],
            'Meta Ads'           => ['label' => 'Meta Ads', 'icon' => 'megaphone', 'color' => 'blue', 'desc' => 'Facebook & Instagram Ad Campaigns'],
            'Mobile Application' => ['label' => 'Mobile Application', 'icon' => 'smartphone', 'color' => 'cyan', 'desc' => 'iOS & Android Mobile Apps'],
            'Custom Software'    => ['label' => 'Custom Software', 'icon' => 'code-2', 'color' => 'slate', 'desc' => 'Web Apps, SaaS, CRM & Portals'],
        ];
    }
}

if (!function_exists('get_service_ai_agents')) {
    /**
     * Returns the pre-configured specialized AI Agents for given services.
     * If no services are provided or empty, returns catalog of all agents.
     */
    function get_service_ai_agents(array $selectedServices = []): array
    {
        $catalog = [
            'SEO' => [
                [
                    'code'        => 'seo_crawler',
                    'name'        => 'SEO & Technical Crawl Auditor',
                    'service'     => 'SEO',
                    'role'        => 'Technical Health & Core Web Vitals Specialist',
                    'model'       => 'GPT-4o (Vision & Code)',
                    'provider'    => 'openai',
                    'icon'        => 'activity',
                    'color'       => 'indigo',
                    'description' => 'Scans sitemaps, robots.txt directives, mobile indexing readiness, redirects and canonical structures.',
                    'tasks'       => [
                        'Sitemap XML & Robots.txt crawl verification',
                        'JSON-LD Schema Markup generation & validation',
                        'Core Web Vitals & technical performance check',
                        'Broken link & redirect loop detection'
                    ]
                ],
                [
                    'code'        => 'seo_keywords',
                    'name'        => 'Keyword & Search Intent Engine',
                    'service'     => 'SEO',
                    'role'        => 'Commercial Intent & Competitor Gap Strategist',
                    'model'       => 'Gemini 1.5 Pro',
                    'provider'    => 'gemini',
                    'icon'        => 'key',
                    'color'       => 'indigo',
                    'description' => 'Uncovers high-volume, low-competition commercial keywords and analyzes competitor ranking strategies.',
                    'tasks'       => [
                        'High-intent transactional keyword discovery',
                        'Competitor keyword overlap & gap extraction',
                        'Search intent segmentation (Informational vs Transactional)',
                        'Long-tail question queries for blog topics'
                    ]
                ],
                [
                    'code'        => 'seo_onpage',
                    'name'        => 'On-Page Content & Meta Architect',
                    'service'     => 'SEO',
                    'role'        => 'Metadata, Heading Structure & NLP Optimizer',
                    'model'       => 'Claude 3.5 Sonnet',
                    'provider'    => 'anthropic',
                    'icon'        => 'file-text',
                    'color'       => 'indigo',
                    'description' => 'Drafts click-worthy title tags, meta descriptions, and semantic H1-H3 content hierarchies.',
                    'tasks'       => [
                        'Optimized meta title & meta description writing',
                        'Semantic heading hierarchy (H1, H2, H3) restructuring',
                        'Internal link anchor text recommendations',
                        'Image ALT text and keyword density balancing'
                    ]
                ],
            ],
            'AEO' => [
                [
                    'code'        => 'aeo_snippet',
                    'name'        => 'Answer Engine & Direct Answer Agent',
                    'service'     => 'AEO',
                    'role'        => 'Featured Snippet & Voice Search Optimizer',
                    'model'       => 'GPT-4o',
                    'provider'    => 'openai',
                    'icon'        => 'bot',
                    'color'       => 'purple',
                    'description' => 'Structures direct, conversational answers designed to capture Google Position 0 and voice query answers.',
                    'tasks'       => [
                        'Google "People Also Ask" (PAA) question-answer cards',
                        'FAQ Schema markup for instant zero-click results',
                        'Voice query conversational phrasing optimization'
                    ]
                ],
            ],
            'GEO' => [
                [
                    'code'        => 'geo_citation',
                    'name'        => 'Generative Engine Citation Architect',
                    'service'     => 'GEO',
                    'role'        => 'Perplexity, ChatGPT & Gemini Citation Strategist',
                    'model'       => 'Gemini 1.5 Pro',
                    'provider'    => 'gemini',
                    'icon'        => 'sparkles',
                    'color'       => 'fuchsia',
                    'description' => 'Builds high-authority digital footprints and entity citations so LLMs reference this project in AI summaries.',
                    'tasks'       => [
                        'LLM knowledge-graph entity verification',
                        'Brand citation and reference placements',
                        'AI Overview summary citation readiness audit'
                    ]
                ],
            ],
            'SMO' => [
                [
                    'code'        => 'smo_content',
                    'name'        => 'Social Media & Carousel Architect',
                    'service'     => 'SMO',
                    'role'        => 'Multi-Platform Editorial & Viral Hook Strategist',
                    'model'       => 'Claude 3.5 Sonnet',
                    'provider'    => 'anthropic',
                    'icon'        => 'share-2',
                    'color'       => 'pink',
                    'description' => 'Creates 30-day cross-platform social editorial calendars, carousel slides, and high-retention hooks.',
                    'tasks'       => [
                        '30-day monthly multi-channel content calendar',
                        'Viral hook generation for Instagram, LinkedIn & YouTube',
                        'Carousel slide copy and caption with CTA'
                    ]
                ],
                [
                    'code'        => 'smo_growth',
                    'name'        => 'Trend & Hashtag Growth Strategist',
                    'service'     => 'SMO',
                    'role'        => 'Niche Hashtag Clusters & Trend Seeding',
                    'model'       => 'GPT-4o',
                    'provider'    => 'openai',
                    'icon'        => 'trending-up',
                    'color'       => 'pink',
                    'description' => 'Monitors trending audio, niche communities, and creates low-competition hashtag stacks.',
                    'tasks'       => [
                        'Targeted hashtag cluster generation (30-tag sets)',
                        'Community engagement script & DM reply flows',
                        'Weekly trending audio & format suggestions'
                    ]
                ],
            ],
            'PPC' => [
                [
                    'code'        => 'ppc_ads',
                    'name'        => 'Google Ads & PPC Campaign Strategist',
                    'service'     => 'PPC',
                    'role'        => 'Search Ad Copies, Negative Keywords & Quality Score Booster',
                    'model'       => 'GPT-4o',
                    'provider'    => 'openai',
                    'icon'        => 'target',
                    'color'       => 'amber',
                    'description' => 'Builds high-converting Responsive Search Ads (RSA), ad extensions, and negative keyword lists.',
                    'tasks'       => [
                        'RSA headlines (15x) & descriptions (4x) with A/B angles',
                        'Negative keyword lists to prevent ad spend bleed',
                        'Landing page message-match & Quality Score audit'
                    ]
                ],
            ],
            'Meta Ads' => [
                [
                    'code'        => 'meta_creative',
                    'name'        => 'Meta Creative & ROAS Optimizer',
                    'service'     => 'Meta Ads',
                    'role'        => 'Facebook & Instagram Ad Angles & Pixel Tracking',
                    'model'       => 'GPT-4o',
                    'provider'    => 'openai',
                    'icon'        => 'megaphone',
                    'color'       => 'blue',
                    'description' => 'Designs high-CTR UGC video storyboards, pain-point hooks, and custom/lookalike audience strategies.',
                    'tasks'       => [
                        'Multiple ad angle hooks (Pain-point, Social proof, Offer)',
                        'Custom & Lookalike audience persona mapping',
                        'UGC creative brief & visual storyboard generation',
                        'Conversions API (CAPI) & Pixel tracking validation'
                    ]
                ],
            ],
            'Website' => [
                [
                    'code'        => 'web_cro',
                    'name'        => 'Website UX & Conversion Optimizer (CRO)',
                    'service'     => 'Website',
                    'role'        => 'Landing Page Wireframes, CTA Hierarchy & Speed Audit',
                    'model'       => 'GPT-4o',
                    'provider'    => 'openai',
                    'icon'        => 'globe',
                    'color'       => 'emerald',
                    'description' => 'Analyzes user journeys, conversion funnels, above-the-fold CTA placement, and web performance.',
                    'tasks'       => [
                        'Above-the-fold hero section conversion audit',
                        'Mobile viewport usability & navigation inspection',
                        'SSL, security headers & technical setup check'
                    ]
                ],
            ],
            'Mobile Application' => [
                [
                    'code'        => 'app_aso',
                    'name'        => 'App Store Optimization (ASO) & Retention Agent',
                    'service'     => 'Mobile Application',
                    'role'        => 'Play Store & App Store Metadata & Push Notifications',
                    'model'       => 'Gemini 1.5 Pro',
                    'provider'    => 'gemini',
                    'icon'        => 'smartphone',
                    'color'       => 'cyan',
                    'description' => 'Optimizes app title, keyword fields, screenshots copy, and user re-engagement push notifications.',
                    'tasks'       => [
                        'App Store / Play Store title & description optimization',
                        'Push notification retention & onboarding copy sequences',
                        'Version release notes & feature update announcements'
                    ]
                ],
            ],
            'Custom Software' => [
                [
                    'code'        => 'software_arch',
                    'name'        => 'Software Architecture & API Strategist',
                    'service'     => 'Custom Software',
                    'role'        => 'Database Schemas, REST/GraphQL APIs & Security Checks',
                    'model'       => 'Claude 3.5 Sonnet',
                    'provider'    => 'anthropic',
                    'icon'        => 'code-2',
                    'color'       => 'slate',
                    'description' => 'Reviews backend API endpoints, database indexing, user authentication, and system scalability.',
                    'tasks'       => [
                        'REST API endpoint specifications & payload validation',
                        'Database query optimization & indexing recommendations',
                        'Role-based access control (RBAC) security review'
                    ]
                ],
            ],
        ];

        if (empty($selectedServices)) {
            $flat = [];
            foreach ($catalog as $serviceName => $agents) {
                foreach ($agents as $ag) {
                    $flat[] = $ag;
                }
            }
            return $flat;
        }

        // Filter by selected services
        $normalizedSelected = array_map('strtolower', array_map('trim', $selectedServices));
        $matched = [];
        foreach ($catalog as $serviceName => $agents) {
            if (in_array(strtolower($serviceName), $normalizedSelected)) {
                foreach ($agents as $ag) {
                    $matched[] = $ag;
                }
            }
        }

        // Fallback: If no match found, at least return Website & SEO agents
        if (empty($matched)) {
            return array_merge($catalog['Website'] ?? [], $catalog['SEO'] ?? []);
        }

        return $matched;
    }
}

if (!function_exists('get_supported_connectors')) {
    /**
     * Returns standard tool connectors supported for agency projects:
     * Full Digital Marketing Suite: SEO, PPC, Analytics, Social Media, E-Commerce, CRM & Tag Management.
     */
    function get_supported_connectors(): array
    {
        return [
            // ==========================================
            // 1. SEO & SEARCH CONSOLE ECOSYSTEM
            // ==========================================
            'google_search_console' => [
                'type'        => 'google_search_console',
                'category'    => 'seo',
                'services'    => ['seo', 'website', 'aeo_geo'],
                'name'        => 'Google Search Console',
                'icon'        => 'search',
                'color'       => 'indigo',
                'badge'       => 'SEO & Indexing',
                'description' => 'Monitor Google search impressions, click-through rates, indexed pages, and sitemaps.',
                'fields'      => [
                    'property_url'     => ['label' => 'Website Property URL', 'type' => 'url', 'placeholder' => 'https://example.com/'],
                    'verification_tag' => ['label' => 'HTML Verification Tag', 'type' => 'text', 'placeholder' => 'google-site-verification=...'],
                    'service_account'  => ['label' => 'Service Account Email (Optional API)', 'type' => 'email', 'placeholder' => 'seo-bot@project.iam.gserviceaccount.com'],
                ]
            ],
            'bing_webmaster' => [
                'type'        => 'bing_webmaster',
                'category'    => 'seo',
                'services'    => ['seo', 'website'],
                'name'        => 'Bing Webmaster & IndexNow',
                'icon'        => 'globe',
                'color'       => 'blue',
                'badge'       => 'Bing SEO & Instant Crawl',
                'description' => 'Instant search indexing on Bing, Yahoo, and DuckDuckGo using IndexNow API protocols.',
                'fields'      => [
                    'site_url'          => ['label' => 'Site URL in Bing', 'type' => 'url', 'placeholder' => 'https://example.com/'],
                    'api_key_indexnow'  => ['label' => 'IndexNow API Key', 'type' => 'text', 'placeholder' => '32-character hexadecimal key'],
                    'verification_code' => ['label' => 'Bing Meta Tag / Code', 'type' => 'text', 'placeholder' => '<meta name="msvalidate.01" content="..." />'],
                ]
            ],
            'google_business_profile' => [
                'type'        => 'google_business_profile',
                'category'    => 'seo',
                'services'    => ['seo', 'smo'],
                'name'        => 'Google Business Profile (GBP)',
                'icon'        => 'map-pin',
                'color'       => 'rose',
                'badge'       => 'Local 3-Pack & Maps',
                'description' => 'Manage Google Maps Local 3-Pack rankings, customer reviews, citations, and call conversions.',
                'fields'      => [
                    'business_name'   => ['label' => 'Verified Business Name', 'type' => 'text', 'placeholder' => 'Exact GBP Name'],
                    'location_id'     => ['label' => 'GBP Location / Account ID', 'type' => 'text', 'placeholder' => 'accounts/123/locations/456'],
                    'place_id'        => ['label' => 'Google Place ID', 'type' => 'text', 'placeholder' => 'ChIJN1t_tDeuEmsRUsoyG83frY4'],
                    'maps_review_url' => ['label' => 'Direct Review Shortlink', 'type' => 'url', 'placeholder' => 'https://g.page/r/.../review'],
                ]
            ],
            'ahrefs' => [
                'type'        => 'ahrefs',
                'category'    => 'seo',
                'services'    => ['seo'],
                'name'        => 'Ahrefs Webmaster API',
                'icon'        => 'trending-up',
                'color'       => 'orange',
                'badge'       => 'Backlinks & DR',
                'description' => 'Real-time Domain Rating (DR), referring domains trajectory, and organic keyword rank tracking.',
                'fields'      => [
                    'target_domain' => ['label' => 'Target Domain', 'type' => 'text', 'placeholder' => 'example.com'],
                    'api_token'     => ['label' => 'Ahrefs API v3 Token', 'type' => 'password', 'placeholder' => 'ahrefs_api_...'],
                    'project_id'    => ['label' => 'Ahrefs Project ID (Optional)', 'type' => 'text', 'placeholder' => 'proj_12345'],
                ]
            ],
            'semrush' => [
                'type'        => 'semrush',
                'category'    => 'seo',
                'services'    => ['seo', 'ppc'],
                'name'        => 'Semrush Search Suite',
                'icon'        => 'bar-chart-2',
                'color'       => 'amber',
                'badge'       => 'Keyword Gap & Audit',
                'description' => 'Site Audit technical health score, backlink toxicity audits, and competitor keyword gap analysis.',
                'fields'      => [
                    'project_id'       => ['label' => 'Semrush Project ID', 'type' => 'text', 'placeholder' => 'e.g. 1294812'],
                    'api_key'          => ['label' => 'Semrush API Key', 'type' => 'password', 'placeholder' => '32-character key'],
                    'database_country' => ['label' => 'Target Database', 'type' => 'text', 'placeholder' => 'in, us, uk, ca'],
                ]
            ],

            // ==========================================
            // 2. PERFORMANCE MARKETING & PAID ADS (PPC)
            // ==========================================
            'google_ads' => [
                'type'        => 'google_ads',
                'category'    => 'ppc',
                'services'    => ['ppc'],
                'name'        => 'Google Ads (Search & Shopping)',
                'icon'        => 'target',
                'color'       => 'indigo',
                'badge'       => 'PPC & Conversions',
                'description' => 'Capture high-intent searches, track ROAS, cost per lead (CPL), and remarketing audience tags.',
                'fields'      => [
                    'customer_id'          => ['label' => 'Google Ads Customer ID (CID)', 'type' => 'text', 'placeholder' => 'XXX-XXX-XXXX'],
                    'conversion_action_id' => ['label' => 'Primary Conversion Action ID', 'type' => 'text', 'placeholder' => 'AW-XXXXXXXXX/YYYYYYYYY'],
                    'remarketing_tag'      => ['label' => 'Remarketing Tag ID', 'type' => 'text', 'placeholder' => 'AW-XXXXXXXXX'],
                ]
            ],
            'meta_ads_pixel' => [
                'type'        => 'meta_ads_pixel',
                'category'    => 'ppc',
                'services'    => ['meta ads', 'smo', 'ppc'],
                'name'        => 'Meta Ads & Conversions API (CAPI)',
                'icon'        => 'megaphone',
                'color'       => 'blue',
                'badge'       => 'Social Ads & ROAS',
                'description' => 'Server-side Conversions API (CAPI) and Meta Pixel for Facebook & Instagram ad attribution.',
                'fields'      => [
                    'pixel_id'          => ['label' => 'Meta Dataset / Pixel ID', 'type' => 'text', 'placeholder' => 'e.g. 123456789012345'],
                    'ad_account_id'     => ['label' => 'Ad Account ID', 'type' => 'text', 'placeholder' => 'act_123456789'],
                    'capi_access_token' => ['label' => 'Server Conversions API Token', 'type' => 'password', 'placeholder' => 'EAA... long-lived access token'],
                ]
            ],
            'linkedin_ads' => [
                'type'        => 'linkedin_ads',
                'category'    => 'ppc',
                'services'    => ['ppc', 'smo'],
                'name'        => 'LinkedIn Campaign Manager',
                'icon'        => 'briefcase',
                'color'       => 'blue',
                'badge'       => 'B2B Lead Gen',
                'description' => 'B2B demographic targeting, LinkedIn Insight Tag conversion tracking, and Lead Gen Form sync.',
                'fields'      => [
                    'ad_account_id'          => ['label' => 'LinkedIn Ad Account ID', 'type' => 'text', 'placeholder' => '501234567'],
                    'insight_tag_partner_id' => ['label' => 'Insight Tag Partner ID', 'type' => 'text', 'placeholder' => 'e.g. 1234567'],
                ]
            ],
            'tiktok_ads' => [
                'type'        => 'tiktok_ads',
                'category'    => 'ppc',
                'services'    => ['smo', 'meta ads', 'ppc'],
                'name'        => 'TikTok Ads Manager',
                'icon'        => 'video',
                'color'       => 'pink',
                'badge'       => 'Short-Form Viral Ads',
                'description' => 'TikTok Pixel events, Spark Ads authorization, and Events API for viral Gen-Z campaigns.',
                'fields'      => [
                    'pixel_id'      => ['label' => 'TikTok Pixel ID', 'type' => 'text', 'placeholder' => 'CXXXXXXXXXXXXXX'],
                    'advertiser_id' => ['label' => 'Advertiser ID', 'type' => 'text', 'placeholder' => 'adv_123456789'],
                ]
            ],

            // ==========================================
            // 3. ANALYTICS, HEATMAPS & CRO
            // ==========================================
            'google_analytics' => [
                'type'        => 'google_analytics',
                'category'    => 'analytics',
                'services'    => ['website', 'seo', 'ppc', 'meta ads', 'smo'],
                'name'        => 'Google Analytics 4 (GA4)',
                'icon'        => 'pie-chart',
                'color'       => 'amber',
                'badge'       => 'Traffic & Users',
                'description' => 'Real-time user engagement, session duration, cross-channel attribution, and conversion funnels.',
                'fields'      => [
                    'measurement_id' => ['label' => 'Measurement ID', 'type' => 'text', 'placeholder' => 'G-XXXXXXXXXX'],
                    'stream_name'    => ['label' => 'Data Stream Name', 'type' => 'text', 'placeholder' => 'Main Production Web Stream'],
                    'api_secret'     => ['label' => 'Measurement Protocol API Secret (Optional)', 'type' => 'password', 'placeholder' => 'Key for server-side events'],
                ]
            ],
            'microsoft_clarity' => [
                'type'        => 'microsoft_clarity',
                'category'    => 'analytics',
                'services'    => ['website', 'seo'],
                'name'        => 'Microsoft Clarity',
                'icon'        => 'eye',
                'color'       => 'cyan',
                'badge'       => 'Session Replays & Heatmaps',
                'description' => '100% free user session video recordings, click/scroll heatmaps, rage clicks, and dead clicks.',
                'fields'      => [
                    'clarity_project_id' => ['label' => 'Clarity Project ID', 'type' => 'text', 'placeholder' => 'e.g. k7q8xxxx'],
                ]
            ],
            'hotjar' => [
                'type'        => 'hotjar',
                'category'    => 'analytics',
                'services'    => ['website'],
                'name'        => 'Hotjar CRO & Feedback',
                'icon'        => 'flame',
                'color'       => 'rose',
                'badge'       => 'Conversion Rate Opt.',
                'description' => 'On-page user survey polls, net promoter scores (NPS), and conversion funnel drop-off analytics.',
                'fields'      => [
                    'site_id' => ['label' => 'Hotjar Site ID', 'type' => 'text', 'placeholder' => 'e.g. 1234567'],
                ]
            ],

            // ==========================================
            // 4. TAG & EVENT INFRASTRUCTURE
            // ==========================================
            'google_tag_manager' => [
                'type'        => 'google_tag_manager',
                'category'    => 'analytics',
                'services'    => ['website', 'ppc', 'meta ads', 'seo'],
                'name'        => 'Google Tag Manager (GTM)',
                'icon'        => 'tag',
                'color'       => 'teal',
                'badge'       => 'Centralized Tag Hub',
                'description' => 'Deploy tracking pixels, custom JavaScript triggers, and data layer variables without code edits.',
                'fields'      => [
                    'container_id' => ['label' => 'Container ID', 'type' => 'text', 'placeholder' => 'GTM-XXXXXXX'],
                    'auth_token'   => ['label' => 'Environment Auth Token (Optional)', 'type' => 'text', 'placeholder' => 'env-1...'],
                ]
            ],

            // ==========================================
            // 5. E-COMMERCE & CMS PLATFORMS
            // ==========================================
            'shopify' => [
                'type'        => 'shopify',
                'category'    => 'ecommerce',
                'services'    => ['website', 'seo', 'ppc'],
                'name'        => 'Shopify E-Commerce Store',
                'icon'        => 'shopping-bag',
                'color'       => 'emerald',
                'badge'       => 'Shopify Sync',
                'description' => 'Sync product catalog, dynamic price feeds, cart abandonment tracking, and inventory data.',
                'fields'      => [
                    'shop_domain'        => ['label' => 'Store Domain', 'type' => 'text', 'placeholder' => 'your-store.myshopify.com'],
                    'admin_access_token' => ['label' => 'Admin API Access Token', 'type' => 'password', 'placeholder' => 'shpat_xxxxxxxxxxxxxxxxxxxxx'],
                    'custom_app_name'    => ['label' => 'Custom App Name (Optional)', 'type' => 'text', 'placeholder' => 'AgencyOS Connector'],
                ]
            ],
            'wordpress_woocommerce' => [
                'type'        => 'wordpress_woocommerce',
                'category'    => 'ecommerce',
                'services'    => ['website', 'seo'],
                'name'        => 'WordPress & WooCommerce REST API',
                'icon'        => 'code',
                'color'       => 'blue',
                'badge'       => 'WP & Woo API',
                'description' => 'Direct connection to WordPress REST API for automated blog publishing and WooCommerce order tracking.',
                'fields'      => [
                    'site_url'        => ['label' => 'WordPress Site URL', 'type' => 'url', 'placeholder' => 'https://example.com'],
                    'wp_username'     => ['label' => 'WordPress Admin Username', 'type' => 'text', 'placeholder' => 'admin'],
                    'app_password'    => ['label' => 'Application Password', 'type' => 'password', 'placeholder' => 'xxxx xxxx xxxx xxxx (From WP Admin > Profile)'],
                    'consumer_key'    => ['label' => 'WooCommerce Consumer Key (Optional)', 'type' => 'text', 'placeholder' => 'ck_xxxxxxxxxxxxxxxxxxxxxxxxxx'],
                    'consumer_secret' => ['label' => 'WooCommerce Consumer Secret (Optional)', 'type' => 'password', 'placeholder' => 'cs_xxxxxxxxxxxxxxxxxxxxxxxxxx'],
                ]
            ],

            // ==========================================
            // 6. SOCIAL MEDIA & MESSAGING (SMO)
            // ==========================================
            'whatsapp_business' => [
                'type'        => 'whatsapp_business',
                'category'    => 'social',
                'services'    => ['smo', 'website'],
                'name'        => 'WhatsApp Cloud API',
                'icon'        => 'message-circle',
                'color'       => 'emerald',
                'badge'       => 'Automated Lead Nurture',
                'description' => 'Instant click-to-WhatsApp ad triggers, automated lead qualification, and CRM notifications.',
                'fields'      => [
                    'phone_number_id' => ['label' => 'Phone Number ID', 'type' => 'text', 'placeholder' => 'e.g. 104829102910291'],
                    'waba_id'         => ['label' => 'WhatsApp Business Account ID', 'type' => 'text', 'placeholder' => 'e.g. 91829102910291'],
                    'access_token'    => ['label' => 'Permanent System User Token', 'type' => 'password', 'placeholder' => 'EAA... permanent token'],
                ]
            ],

            // ==========================================
            // 7. CRM & EMAIL MARKETING (LEAD RETENTION)
            // ==========================================
            'hubspot_crm' => [
                'type'        => 'hubspot_crm',
                'category'    => 'crm',
                'services'    => ['seo', 'ppc', 'meta ads', 'website'],
                'name'        => 'HubSpot Inbound CRM',
                'icon'        => 'users',
                'color'       => 'orange',
                'badge'       => 'Lead Scoring & Deals',
                'description' => 'Real-time pipeline synchronization, lead qualification stages, and deal closed-won attribution.',
                'fields'      => [
                    'portal_id'    => ['label' => 'HubSpot Portal ID (Hub ID)', 'type' => 'text', 'placeholder' => 'e.g. 2194812'],
                    'access_token' => ['label' => 'Private App Access Token', 'type' => 'password', 'placeholder' => 'pat-na1-xxxxxxxx-xxxx-xxxx'],
                ]
            ],
            'klaviyo_email' => [
                'type'        => 'klaviyo_email',
                'category'    => 'crm',
                'services'    => ['meta ads', 'website', 'ppc'],
                'name'        => 'Klaviyo / Mailchimp Automation',
                'icon'        => 'mail',
                'color'       => 'amber',
                'badge'       => 'Email Flows & SMS',
                'description' => 'Trigger welcome series, abandoned cart recovery sequences, and VIP customer retention flows.',
                'fields'      => [
                    'public_api_key'  => ['label' => 'Public API Key / Site ID', 'type' => 'text', 'placeholder' => 'e.g. ABCD12'],
                    'private_api_key' => ['label' => 'Private API Key', 'type' => 'password', 'placeholder' => 'pk_xxxxxxxxxxxxxxxxxxxxxx'],
                    'list_id'         => ['label' => 'Master Newsletter / SMS List ID', 'type' => 'text', 'placeholder' => 'e.g. Y7aBcD'],
                ]
            ],

            // ==========================================
            // 8. CUSTOM WEBHOOK & INTEGRATIONS
            // ==========================================
            'custom_api' => [
                'type'        => 'custom_api',
                'category'    => 'custom',
                'services'    => ['custom software', 'website'],
                'name'        => 'Custom API / Webhook Endpoint',
                'icon'        => 'link-2',
                'color'       => 'slate',
                'badge'       => 'Custom Integration',
                'description' => 'Deliver real-time webhook payloads, custom backend ERP sync, or zapier / make.com automation webhooks.',
                'fields'      => [
                    'endpoint_url'   => ['label' => 'API / Webhook Endpoint', 'type' => 'url', 'placeholder' => 'https://api.example.com/v1/webhook'],
                    'api_key'        => ['label' => 'API Secret Bearer Token (Optional)', 'type' => 'password', 'placeholder' => 'Bearer token or secret key'],
                    'webhook_secret' => ['label' => 'HMAC Webhook Secret (Optional)', 'type' => 'text', 'placeholder' => 'whsec_xxxxxxxx'],
                ]
            ],
        ];
    }
}

if (!function_exists('format_file_size')) {
    /**
     * Formats bytes into human-readable size (e.g. 2.4 MB)
     */
    function format_file_size(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        } elseif ($bytes > 0) {
            return $bytes . ' B';
        }
        return '0 B';
    }
}

if (!function_exists('render_department_badges')) {
    /**
     * Renders modern, responsive badges for single or multiple services/sections
     */
    function render_department_badges(?string $departmentStr, int $max = 3): string
    {
        if (empty($departmentStr)) {
            $departmentStr = 'Website';
        }

        $colorMap = [
            'website'            => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20',
            'seo'                => 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 border-indigo-200 dark:border-indigo-500/20',
            'aeo'                => 'bg-purple-50 dark:bg-purple-500/10 text-purple-700 dark:text-purple-400 border-purple-200 dark:border-purple-500/20',
            'geo'                => 'bg-fuchsia-50 dark:bg-fuchsia-500/10 text-fuchsia-700 dark:text-fuchsia-400 border-fuchsia-200 dark:border-fuchsia-500/20',
            'smo'                => 'bg-pink-50 dark:bg-pink-500/10 text-pink-700 dark:text-pink-400 border-pink-200 dark:border-pink-500/20',
            'ppc'                => 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/20',
            'meta ads'           => 'bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-500/20',
            'meta_ads'           => 'bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-500/20',
            'mobile application' => 'bg-cyan-50 dark:bg-cyan-500/10 text-cyan-700 dark:text-cyan-400 border-cyan-200 dark:border-cyan-500/20',
            'mobile_app'         => 'bg-cyan-50 dark:bg-cyan-500/10 text-cyan-700 dark:text-cyan-400 border-cyan-200 dark:border-cyan-500/20',
            'custom software'    => 'bg-slate-100 dark:bg-slate-700/60 text-slate-800 dark:text-slate-200 border-slate-300 dark:border-slate-600',
            'custom_software'    => 'bg-slate-100 dark:bg-slate-700/60 text-slate-800 dark:text-slate-200 border-slate-300 dark:border-slate-600',
            'content'            => 'bg-purple-50 dark:bg-purple-500/10 text-purple-700 dark:text-purple-400 border-purple-200 dark:border-purple-500/20',
            'social'             => 'bg-pink-50 dark:bg-pink-500/10 text-pink-700 dark:text-pink-400 border-pink-200 dark:border-pink-500/20',
            'multidisciplinary'  => 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/20',
        ];

        $parts = array_filter(array_map('trim', explode(',', $departmentStr)));
        if (empty($parts)) {
            $parts = ['Website'];
        }

        $html = '<div class="flex flex-wrap items-center gap-1.5">';
        $shown = array_slice($parts, 0, $max);
        foreach ($shown as $p) {
            $key = strtolower(trim($p));
            $cls = $colorMap[$key] ?? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 border-indigo-200 dark:border-indigo-500/20';
            $html .= '<span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider border ' . $cls . '">' . esc(strtoupper($p)) . '</span>';
        }

        if (count($parts) > $max) {
            $rem = count($parts) - $max;
            $html .= '<span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-slate-100 dark:bg-dark-600 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700" title="' . esc(implode(', ', $parts)) . '">+' . $rem . '</span>';
        }

        $html .= '</div>';
        return $html;
    }
}
