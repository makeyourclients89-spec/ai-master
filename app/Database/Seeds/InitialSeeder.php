<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $now = date('Y-m-d H:i:s');

        // 1. Seed Default Admin User
        $db->table('users')->insert([
            'name'       => 'Agency Owner',
            'email'      => 'admin@agency.com',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'role'       => 'owner',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $userId = $db->insertID();

        // 2. Seed Default Workspaces
        $db->table('workspaces')->insert([
            'name'       => 'AI Master Agency',
            'slug'       => 'ai-master-agency',
            'owner_id'   => $userId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $workspaceId = $db->insertID();

        // 3. Seed Workspace Membership
        $db->table('workspace_members')->insert([
            'workspace_id' => $workspaceId,
            'user_id'      => $userId,
            'role'         => 'owner',
            'created_at'   => $now,
        ]);

        // Add additional team members
        $team = [
            ['name' => 'Rohit Sharma', 'email' => 'rohit@agency.com', 'role' => 'admin'],
            ['name' => 'Priya Patel', 'email' => 'priya@agency.com', 'role' => 'member'],
            ['name' => 'Aarav Mehta', 'email' => 'aarav@agency.com', 'role' => 'approver'],
        ];
        foreach ($team as $m) {
            $db->table('users')->insert([
                'name'       => $m['name'],
                'email'      => $m['email'],
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => $m['role'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $newUId = $db->insertID();
            $db->table('workspace_members')->insert([
                'workspace_id' => $workspaceId,
                'user_id'      => $newUId,
                'role'         => $m['role'],
                'created_at'   => $now,
            ]);
        }

        // 4. Seed Projects
        $projects = [
            [
                'workspace_id'    => $workspaceId,
                'name'            => 'Apex Search SEO Growth',
                'department'      => 'seo',
                'platform'        => 'wordpress',
                'objective'       => 'Dominate high-intent commercial keywords, optimize Core Web Vitals, and scale organic lead pipeline by 140%.',
                'audience'        => 'B2B Enterprise Decision Makers & CTOs',
                'market'          => 'India & Global',
                'website'         => 'https://apex-search.agency',
                'success_metrics' => 'Organic traffic +150%, 450+ qualified inbound leads/month, Page speed 95+ score',
                'status'          => 'active',
                'health_score'    => 96,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'workspace_id'    => $workspaceId,
                'name'            => 'OmniChannel Social Domination',
                'department'      => 'social',
                'platform'        => 'custom',
                'objective'       => 'Automated viral short-form video repurposing, multi-platform publishing, and community engagement.',
                'audience'        => 'Tech Enthusiasts, Startup Founders & Creator Economy',
                'market'          => 'US, UAE & India',
                'website'         => 'https://omnisocial.studio',
                'success_metrics' => '1.2M+ Monthly impressions, 35k community followers, 4.8% average engagement rate',
                'status'          => 'active',
                'health_score'    => 91,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'workspace_id'    => $workspaceId,
                'name'            => 'AI Content Engine & Authority Hub',
                'department'      => 'content',
                'platform'        => 'custom',
                'objective'       => 'Deploy semantic topic clusters, long-form thought leadership articles, and programmatic SEO hubs.',
                'audience'        => 'Enterprise Software Buyers & Product Managers',
                'market'          => 'Global',
                'website'         => 'https://contentengine.ai',
                'success_metrics' => '80 indexed technical articles, 45% reduction in CAC, top 3 ranking for 25 target terms',
                'status'          => 'active',
                'health_score'    => 88,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'workspace_id'    => $workspaceId,
                'name'            => 'E-Commerce Funnel Optimization',
                'department'      => 'multidisciplinary',
                'platform'        => 'shopify',
                'objective'       => 'CRO audits, dynamic retargeting creatives, automated abandoned checkout recovery flows.',
                'audience'        => 'D2C Retail Consumers',
                'market'          => 'India',
                'website'         => 'https://trendstore.shop',
                'success_metrics' => 'Checkout conversion lift +28%, ROAS 4.2x, reduced cart abandonment rate',
                'status'          => 'archived',
                'health_score'    => 85,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
        ];

        foreach ($projects as $p) {
            $db->table('projects')->insert($p);
            $pId = $db->insertID();

            // Add tasks for this project
            $db->table('project_tasks')->insertBatch([
                [
                    'project_id'    => $pId,
                    'title'         => 'Technical Audit & Schema Validation',
                    'description'   => 'Audit site speed, structured data, canonical tags and server response times.',
                    'category'      => 'seo',
                    'priority'      => 'high',
                    'status'        => 'completed',
                    'assigned_user' => 'Rohit Sharma',
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ],
                [
                    'project_id'    => $pId,
                    'title'         => 'High-Intent Content Strategy Brief',
                    'description'   => 'Map buyer journey search intent to 12 cornerstone pillar pieces.',
                    'category'      => 'content',
                    'priority'      => 'high',
                    'status'        => 'in_progress',
                    'assigned_user' => 'Priya Patel',
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ],
                [
                    'project_id'    => $pId,
                    'title'         => 'AI Workflow Integration & Prompt Tuning',
                    'description'   => 'Configure automated review pipeline with Claude 3.5 Sonnet and Gemini.',
                    'category'      => 'seo',
                    'priority'      => 'medium',
                    'status'        => 'pending',
                    'assigned_user' => 'Aarav Mehta',
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ],
            ]);

            // Add connectors for project
            $db->table('connectors')->insertBatch([
                [
                    'project_id'  => $pId,
                    'type'        => 'wordpress',
                    'name'        => 'WordPress CMS Sync',
                    'config_json' => json_encode(['endpoint' => 'https://apex-search.agency/wp-json/wp/v2', 'status' => 'connected']),
                    'status'      => 'connected',
                    'last_sync'   => $now,
                    'created_at'  => $now,
                ],
                [
                    'project_id'  => $pId,
                    'type'        => 'google_analytics',
                    'name'        => 'Google Analytics 4',
                    'config_json' => json_encode(['property_id' => 'GA4-9821382', 'status' => 'live']),
                    'status'      => 'connected',
                    'last_sync'   => $now,
                    'created_at'  => $now,
                ],
            ]);
        }

        // 5. Seed AI Agents
        $db->table('ai_agents')->insertBatch([
            [
                'workspace_id'  => $workspaceId,
                'provider'      => 'openai',
                'name'          => 'SEO & Schema Architect',
                'model'         => 'gpt-4o',
                'api_key'       => 'sk-proj-••••••••••••••••••••••••••••',
                'status'        => 'active',
                'system_prompt' => 'You are an elite Technical SEO and Schema markup specialist. Optimize search visibility, structured data, and content relevance.',
                'total_runs'    => 248,
                'created_at'    => $now,
            ],
            [
                'workspace_id'  => $workspaceId,
                'provider'      => 'gemini',
                'name'          => 'Multi-Modal Market Researcher',
                'model'         => 'gemini-1.5-pro',
                'api_key'       => 'AIzaSy••••••••••••••••••••••••••••',
                'status'        => 'active',
                'system_prompt' => 'You analyze competitive intelligence, SERP results, audio/video briefs and draft strategic growth reports.',
                'total_runs'    => 189,
                'created_at'    => $now,
            ],
            [
                'workspace_id'  => $workspaceId,
                'provider'      => 'anthropic',
                'name'          => 'Creative Copy & Content Engine',
                'model'         => 'claude-3-5-sonnet',
                'api_key'       => 'sk-ant-••••••••••••••••••••••••••••',
                'status'        => 'active',
                'system_prompt' => 'Craft viral hook intros, high-conversion copy, newsletters and deep thought leadership essays.',
                'total_runs'    => 312,
                'created_at'    => $now,
            ],
        ]);

        // 6. Seed Activities
        $db->table('activity_logs')->insertBatch([
            [
                'workspace_id' => $workspaceId,
                'user_name'    => 'Agency Owner',
                'action'       => 'Created project Apex Search SEO Growth',
                'target'       => 'Project #1',
                'created_at'   => date('Y-m-d H:i:s', strtotime('-15 minutes')),
            ],
            [
                'workspace_id' => $workspaceId,
                'user_name'    => 'Rohit Sharma',
                'action'       => 'Completed Technical Audit & Schema Validation',
                'target'       => 'Task #101',
                'created_at'   => date('Y-m-d H:i:s', strtotime('-1 hour')),
            ],
            [
                'workspace_id' => $workspaceId,
                'user_name'    => 'Priya Patel',
                'action'       => 'Updated brief for OmniChannel Social Domination',
                'target'       => 'Project #2',
                'created_at'   => date('Y-m-d H:i:s', strtotime('-3 hours')),
            ],
            [
                'workspace_id' => $workspaceId,
                'user_name'    => 'Agency Owner',
                'action'       => 'Connected Google Analytics 4 integration',
                'target'       => 'Integration',
                'created_at'   => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
        ]);

        // 7. Seed Notifications
        $db->table('notifications')->insertBatch([
            [
                'workspace_id' => $workspaceId,
                'title'        => 'New Project Created',
                'message'      => 'Apex Search SEO Growth was successfully initialized with high-priority deliverables.',
                'kind'         => 'success',
                'is_read'      => false,
                'created_at'   => date('Y-m-d H:i:s', strtotime('-10 minutes')),
            ],
            [
                'workspace_id' => $workspaceId,
                'title'        => 'AI Agent Ready',
                'message'      => 'Claude 3.5 Sonnet agent configured and active for content pipeline.',
                'kind'         => 'info',
                'is_read'      => false,
                'created_at'   => date('Y-m-d H:i:s', strtotime('-2 hours')),
            ],
        ]);
    }
}
