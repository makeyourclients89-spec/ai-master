<?php

namespace App\Services;

use App\Models\ProjectTaskModel;
use App\Models\ActivityLogModel;

class TaskIntelligenceService
{
    /**
     * Generate pre-researched, high-impact Daily, Weekly & Monthly tasks
     * tailored to the project's selected digital marketing services and tech stack.
     *
     * @param int $projectId
     * @param string|array $services
     * @param array $project
     * @param string $assignedEmployee
     * @return int Number of tasks created
     */
    public function generateTasksForProject(int $projectId, $services, array $project = [], string $assignedEmployee = 'Team Member'): int
    {
        $selectedServices = is_array($services) ? $services : array_map('trim', explode(',', (string)$services));
        $selectedServices = array_filter($selectedServices);
        if (empty($selectedServices)) {
            $selectedServices = ['Website', 'SEO'];
        }

        $taskModel = new ProjectTaskModel();
        
        // Get existing task titles for this project to avoid duplicates
        $existing = $taskModel->where('project_id', $projectId)->findAll();
        $existingTitles = array_map(function($t) {
            return strtolower(trim($t['title']));
        }, $existing);

        $tasksToCreate = [];
        $projectName = $project['name'] ?? 'Project';
        $website = $project['website'] ?? '';

        foreach ($selectedServices as $serviceKey) {
            $normalizedService = strtoupper(trim($serviceKey));
            $catalog = $this->getServiceTaskCatalog($normalizedService, $projectName, $website);

            foreach ($catalog as $taskDef) {
                $normTitle = strtolower(trim($taskDef['title']));
                if (in_array($normTitle, $existingTitles)) {
                    continue; // Skip duplicate
                }

                $tasksToCreate[] = [
                    'project_id'         => $projectId,
                    'title'              => $taskDef['title'],
                    'description'        => $taskDef['description'],
                    'expected_output'    => $taskDef['expected_output'],
                    'category'           => strtolower(trim($serviceKey)),
                    'frequency'          => $taskDef['frequency'], // daily, weekly, monthly, one_time
                    'priority'           => $taskDef['priority'] ?? 'medium',
                    'status'             => 'pending',
                    'is_verified'        => 0, // 0 = Needs Employee Review / AI Proposed
                    'assigned_user'      => $assignedEmployee,
                    'assigned_agent'     => $taskDef['assigned_agent'],
                    'recurring_schedule' => $taskDef['recurring_schedule'],
                    'created_at'         => date('Y-m-d H:i:s'),
                    'updated_at'         => date('Y-m-d H:i:s'),
                ];
                $existingTitles[] = $normTitle;
            }
        }

        $createdCount = 0;
        foreach ($tasksToCreate as $taskData) {
            $taskModel->insert($taskData);
            $createdCount++;
        }

        if ($createdCount > 0 && !empty($project['workspace_id'])) {
            ActivityLogModel::log(
                $project['workspace_id'],
                'AI Agent Task Engine',
                "Generated {$createdCount} pre-researched Daily, Weekly & Monthly tasks for services: " . implode(', ', $selectedServices),
                "Project #{$projectId}"
            );
        }

        return $createdCount;
    }

    /**
     * Complete Digital Marketing Deliverable & Task Blueprint
     * Researched for Maximum Agency ROI & Performance Cadence
     */
    public function getServiceTaskCatalog(string $service, string $projectName, string $website): array
    {
        switch ($service) {
            case 'SEO':
                return [
                    [
                        'title'              => 'Daily Google Search Console Indexing & 404 Crawl Error Check',
                        'frequency'          => 'daily',
                        'assigned_agent'     => 'SEO Technical Crawl Auditor',
                        'priority'           => 'high',
                        'recurring_schedule' => 'Daily 09:30 AM',
                        'description'        => 'GSC Coverage & Page Indexing report check karein. New published URLs inspect karein aur 404 / 500 server errors instantly alert karein.',
                        'expected_output'    => 'Daily Indexing Status Log + zero-crawl error confirmation.'
                    ],
                    [
                        'title'              => 'Daily Top 20 Commercial Keywords SERP Rank Tracking',
                        'frequency'          => 'daily',
                        'assigned_agent'     => 'Keyword & Search Intent Engine',
                        'priority'           => 'medium',
                        'recurring_schedule' => 'Daily 10:00 AM',
                        'description'        => 'High-volume money keywords ke positions monitor karein. Competitor algorithm shifts aur CTR drop detect karein.',
                        'expected_output'    => 'Daily SERP Fluctuations Summary with winners & losers.'
                    ],
                    [
                        'title'              => 'Weekly On-Page Content, NLP & Meta Optimization (2 Priority URLs)',
                        'frequency'          => 'weekly',
                        'assigned_agent'     => 'On-Page Content & Meta Architect',
                        'priority'           => 'high',
                        'recurring_schedule' => 'Every Tuesday 11:00 AM',
                        'description'        => '2 focus URLs ka Title (60 chars), Meta Description (150 chars), H1-H3 headings, internal links aur keyword density optimize karein.',
                        'expected_output'    => 'Optimized On-Page Brief + Schema Markup ready to publish.'
                    ],
                    [
                        'title'              => 'Weekly High-Authority Backlink Prospecting & Outreach Pitching',
                        'frequency'          => 'weekly',
                        'assigned_agent'     => 'Competitor & Backlink Gap Strategist',
                        'priority'           => 'medium',
                        'recurring_schedule' => 'Every Thursday 02:00 PM',
                        'description'        => 'Relevant niche websites (DA 40+) shortlist karein. Personalized guest post pitches aur unlinked brand mentions claim karein.',
                        'expected_output'    => 'List of 10 qualified backlink prospects + drafted outreach emails.'
                    ],
                    [
                        'title'              => 'Weekly Core Web Vitals & PageSpeed Performance Diagnostics',
                        'frequency'          => 'weekly',
                        'assigned_agent'     => 'SEO Technical Crawl Auditor',
                        'priority'           => 'medium',
                        'recurring_schedule' => 'Every Friday 04:00 PM',
                        'description'        => 'Mobile LCP, INP aur CLS metrics test karein. Large uncompressed images aur unneeded JS render-blocking scripts flag karein.',
                        'expected_output'    => 'Weekly PageSpeed Score report with specific developer action items.'
                    ],
                    [
                        'title'              => 'Monthly Comprehensive Full-Site Technical SEO Audit',
                        'frequency'          => 'monthly',
                        'assigned_agent'     => 'SEO Technical Crawl Auditor',
                        'priority'           => 'high',
                        'recurring_schedule' => '1st of Every Month',
                        'description'        => 'Deep website crawl (Sitemap, canonicals, duplicate content, robots.txt directives, pagination aur mobile indexing).',
                        'expected_output'    => '40-Point Technical SEO Health Audit Spreadsheet & Fix Checklist.'
                    ],
                    [
                        'title'              => 'Monthly Competitor Keyword Gap & Content Strategy Roadmap',
                        'frequency'          => 'monthly',
                        'assigned_agent'     => 'Keyword & Search Intent Engine',
                        'priority'           => 'high',
                        'recurring_schedule' => '5th of Every Month',
                        'description'        => 'Top 3 competitors ke ranking keywords extract karein. Jo high-converting keywords client ke paas nahi hain unka topic cluster banayein.',
                        'expected_output'    => 'Top 30 Missing Keyword Blueprint + 4 New Pillar Blog Outlines.'
                    ],
                    [
                        'title'              => 'Monthly Organic Traffic, Keyword Growth & ROI Client Brief',
                        'frequency'          => 'monthly',
                        'assigned_agent'     => 'Executive Analytics Reporting AI',
                        'priority'           => 'high',
                        'recurring_schedule' => 'Last Working Day of Month',
                        'description'        => 'GA4 + GSC se Month-over-Month organic sessions, goal conversions aur keyword rankings ka executive client report taiyar karein.',
                        'expected_output'    => 'Client-Ready Executive PDF/Deck with organic growth highlights.'
                    ],
                ];

            case 'SMO':
                return [
                    [
                        'title'              => 'Daily Social Media Inbound Comments, DMs & Brand Mentions Triage',
                        'frequency'          => 'daily',
                        'assigned_agent'     => 'Social Media Growth Agent',
                        'priority'           => 'high',
                        'recurring_schedule' => 'Daily 10:30 AM & 05:00 PM',
                        'description'        => 'Instagram, Facebook aur LinkedIn par customer comments aur direct messages ka instant response dekar engagement rate maintain karein.',
                        'expected_output'    => '100% replied comments log + hot lead alerts sent to sales.'
                    ],
                    [
                        'title'              => 'Daily Viral Reels Hook & Trending Audio Scouting',
                        'frequency'          => 'daily',
                        'assigned_agent'     => 'Social Content & Viral Hook Specialist',
                        'priority'           => 'medium',
                        'recurring_schedule' => 'Daily 11:30 AM',
                        'description'        => 'Niche me trending reel audios, popular meme formats aur viral angles scout karein jo brand identity se match karein.',
                        'expected_output'    => 'Daily 2 Actionable Viral Video Script Concepts.'
                    ],
                    [
                        'title'              => 'Weekly Social Content Batch Production (3 Carousels + 2 Reels + 5 Stories)',
                        'frequency'          => 'weekly',
                        'assigned_agent'     => 'Social Content & Viral Hook Specialist',
                        'priority'           => 'high',
                        'recurring_schedule' => 'Every Monday 11:00 AM',
                        'description'        => 'Agle hafte ke liye high-value educational carousels, entertaining reels scripts, engaging captions aur strategic hashtags batch karein.',
                        'expected_output'    => 'Complete Weekly Content Calendar ready for client review & scheduling.'
                    ],
                    [
                        'title'              => 'Weekly Community Engagement & Targeted Niche Accounts Networking',
                        'frequency'          => 'weekly',
                        'assigned_agent'     => 'Social Media Growth Agent',
                        'priority'           => 'medium',
                        'recurring_schedule' => 'Every Wednesday 03:00 PM',
                        'description'        => 'Target audience ke favorite 20 authority accounts par thoughtful comments aur discussions initiate karein profile visits badhane ke liye.',
                        'expected_output'    => '20 Quality Community Engagements Log with profile traffic spike.'
                    ],
                    [
                        'title'              => 'Monthly Social Reach, Follower Growth & Top Performing Creative Review',
                        'frequency'          => 'monthly',
                        'assigned_agent'     => 'Social Media Growth Agent',
                        'priority'           => 'high',
                        'recurring_schedule' => '2nd of Every Month',
                        'description'        => 'Total impressions, profile reach, follower velocity aur engagement rate ka deep breakdown. Highest-converting format replicate karein.',
                        'expected_output'    => 'Monthly Social Growth Presentation with next month content pillars.'
                    ],
                ];

            case 'PPC':
                return [
                    [
                        'title'              => 'Daily Google Ads Budget Pacing & Impression Share Monitoring',
                        'frequency'          => 'daily',
                        'assigned_agent'     => 'Google Ads Search Specialist',
                        'priority'           => 'high',
                        'recurring_schedule' => 'Daily 09:00 AM',
                        'description'        => 'Daily spend check karein taaki budget premature drain na ho. Lost Impression Share (Budget) aur Lost IS (Rank) track karein.',
                        'expected_output'    => 'Daily Spend vs Budget Health Check + zero overspend confirmation.'
                    ],
                    [
                        'title'              => 'Daily Search Terms Scrubbing & Negative Keywords Addition',
                        'frequency'          => 'daily',
                        'assigned_agent'     => 'Google Ads Search Specialist',
                        'priority'           => 'high',
                        'recurring_schedule' => 'Daily 02:00 PM',
                        'description'        => 'Real search terms inspect karein. Irrelevant clicks, competitor names ya junk queries ko Negative Keyword list me add karein.',
                        'expected_output'    => 'Clean search term audit log + waste ad spend saved.'
                    ],
                    [
                        'title'              => 'Weekly Keyword Bid Adjustments & Quality Score Diagnostic',
                        'frequency'          => 'weekly',
                        'assigned_agent'     => 'PPC Optimization Agent',
                        'priority'           => 'high',
                        'recurring_schedule' => 'Every Wednesday 12:00 PM',
                        'description'        => 'High conversion keywords ke bids adjust karein. Ad Relevance, Expected CTR aur Landing Page Experience improve karein.',
                        'expected_output'    => 'Bid modifier adjustment log + Quality Score improvements table.'
                    ],
                    [
                        'title'              => 'Weekly Responsive Search Ads (RSA) Headlines & Descriptions A/B Testing',
                        'frequency'          => 'weekly',
                        'assigned_agent'     => 'PPC Copywriting Specialist',
                        'priority'           => 'medium',
                        'recurring_schedule' => 'Every Friday 11:30 AM',
                        'description'        => 'Underperforming RSA assets identify karein. 3 naye high-CTR emotional & urgency-based headlines test karein.',
                        'expected_output'    => 'Updated RSA ad assets with higher predicted CTR.'
                    ],
                    [
                        'title'              => 'Monthly PPC Campaign RoAS, Cost-Per-Acquisition (CPA) & Funnel Scaling Audit',
                        'frequency'          => 'monthly',
                        'assigned_agent'     => 'PPC Strategy Director',
                        'priority'           => 'high',
                        'recurring_schedule' => '1st of Every Month',
                        'description'        => 'Cost-per-lead, Return on Ad Spend (RoAS), device performance aur geographic scaling points ka full analysis.',
                        'expected_output'    => 'Executive Monthly PPC Deck + Next Month Budget Reallocation Strategy.'
                    ],
                ];

            case 'Meta Ads':
            case 'META ADS':
                return [
                    [
                        'title'              => 'Daily Meta Ads Cost-Per-Lead (CPL), RoAS & Ad Frequency Watch',
                        'frequency'          => 'daily',
                        'assigned_agent'     => 'Meta Performance Ads Agent',
                        'priority'           => 'high',
                        'recurring_schedule' => 'Daily 09:15 AM',
                        'description'        => 'CPL, CPA aur Purchase RoAS monitor karein. Agar ad frequency 3.5 cross kare toh ad fatigue identify karke scale ya pause karein.',
                        'expected_output'    => 'Daily Performance Metric Snap + Fatigue Alerts.'
                    ],
                    [
                        'title'              => 'Weekly Meta Ad Creative Refresh (3 New Creative Hooks & Ad Copy Angles)',
                        'frequency'          => 'weekly',
                        'assigned_agent'     => 'Meta Creative Strategist',
                        'priority'           => 'high',
                        'recurring_schedule' => 'Every Monday 02:00 PM',
                        'description'        => 'Fatigued creatives replace karne ke liye 3 naye visual creatives, UGC testimonial angles aur primary ad copies launch karein.',
                        'expected_output'    => '3 Ready-to-Publish Ad Variations (Images/Video Hooks + Copy).'
                    ],
                    [
                        'title'              => 'Weekly Lookalike & Custom Retargeting Audience Scaling',
                        'frequency'          => 'weekly',
                        'assigned_agent'     => 'Meta Performance Ads Agent',
                        'priority'           => 'medium',
                        'recurring_schedule' => 'Every Thursday 03:30 PM',
                        'description'        => 'Website visitors, video viewers aur buyers ki custom audiences refresh karein. Top 1% - 3% Lookalikes test karein.',
                        'expected_output'    => 'Audience Scaling Plan + Retargeting budget allocation.'
                    ],
                    [
                        'title'              => 'Monthly Meta Conversions API (CAPI) & Pixel Event Health Audit',
                        'frequency'          => 'monthly',
                        'assigned_agent'     => 'Meta Performance Ads Agent',
                        'priority'           => 'high',
                        'recurring_schedule' => '3rd of Every Month',
                        'description'        => 'CAPI server-side event match quality score (8.0+ target), deduplication, aur Purchase/Lead trigger accuracy verify karein.',
                        'expected_output'    => 'CAPI Event Quality Report + Tracking Health Certificate.'
                    ],
                ];

            case 'AEO':
            case 'GEO':
                return [
                    [
                        'title'              => 'Weekly AI Answer Engine (ChatGPT, Perplexity, Claude) Brand Presence Audit',
                        'frequency'          => 'weekly',
                        'assigned_agent'     => 'AEO Direct Answer Agent',
                        'priority'           => 'high',
                        'recurring_schedule' => 'Every Tuesday 03:00 PM',
                        'description'        => 'Key transactional queries ChatGPT, Perplexity aur Gemini me run karke verify karein ki brand recommend ho raha hai ya nahi.',
                        'expected_output'    => 'AI Citation Scorecard + Missing Query Opportunities.'
                    ],
                    [
                        'title'              => 'Monthly FAQ Schema & Conversational Knowledge Graph Expansion',
                        'frequency'          => 'monthly',
                        'assigned_agent'     => 'GEO Entity Architect',
                        'priority'           => 'high',
                        'recurring_schedule' => '4th of Every Month',
                        'description'        => 'High-volume question queries ke liye direct answer cards aur Schema.org structured data deploy karein.',
                        'expected_output'    => '5 Optimized Direct Answer Cards + Validated JSON-LD Code.'
                    ],
                ];

            case 'Website':
            case 'CUSTOM SOFTWARE':
            case 'MOBILE APPLICATION':
            default:
                return [
                    [
                        'title'              => 'Daily Website Uptime, SSL Certificate & Lead Form Verification',
                        'frequency'          => 'daily',
                        'assigned_agent'     => 'Web Performance & Security Bot',
                        'priority'           => 'high',
                        'recurring_schedule' => 'Daily 08:30 AM',
                        'description'        => 'HTTP 200 status, SSL expiry date aur main contact/checkout form functionality automated ping se verify karein.',
                        'expected_output'    => 'Daily 100% Uptime Log + zero broken form confirmations.'
                    ],
                    [
                        'title'              => 'Weekly CMS / Plugin Security Patches & Cloud Backup Snapshot',
                        'frequency'          => 'weekly',
                        'assigned_agent'     => 'Web Developer Agent',
                        'priority'           => 'high',
                        'recurring_schedule' => 'Every Sunday Night',
                        'description'        => 'Staging environment me security updates test karein aur production backup snapshot verify karein.',
                        'expected_output'    => 'Backup Archive Verified + zero vulnerable plugin alerts.'
                    ],
                    [
                        'title'              => 'Monthly Conversion Rate Optimization (CRO) Heatmap & Funnel Drop-off Audit',
                        'frequency'          => 'monthly',
                        'assigned_agent'     => 'CRO & UX Specialist',
                        'priority'           => 'high',
                        'recurring_schedule' => '6th of Every Month',
                        'description'        => 'Clarity/Hotjar scroll depth aur click heatmaps check karein. Landing page CTA friction points identify karein.',
                        'expected_output'    => 'CRO Audit Findings Deck + 1 High-Impact A/B Test Blueprint.'
                    ],
                ];
        }
    }
}
