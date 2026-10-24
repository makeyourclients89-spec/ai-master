<?php

namespace App\Controllers;

use App\Models\WorkspaceModel;
use App\Models\AiAgentModel;
use App\Models\ActivityLogModel;

class AgentController extends BaseController
{
    protected function getActiveWorkspace()
    {
        $userId = session()->get('user_id');
        $workspaceModel = new WorkspaceModel();
        $workspaces = $workspaceModel->getUserWorkspaces($userId);
        $activeId = session()->get('workspace_id');
        $active = null;
        foreach ($workspaces as $ws) {
            if ($ws['id'] == $activeId) {
                $active = $ws;
                break;
            }
        }
        if (!$active && !empty($workspaces)) {
            $active = $workspaces[0];
        }
        return [$active, $workspaces];
    }

    public function index()
    {
        if (is_client_user()) {
            return redirect()->to(site_url('dashboard'))->with('error', 'Access restricted: AI Agents & API Keys are reserved for agency staff.');
        }

        [$activeWorkspace, $workspaces] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'];

        $agentModel = new AiAgentModel();
        $agents = $agentModel->where('workspace_id', $workspaceId)->findAll();

        return view('agents/index', [
            'activeWorkspace' => $activeWorkspace,
            'workspaces'      => $workspaces,
            'agents'          => $agents,
            'title'           => 'AI Agents & API Keys',
            'currentPage'     => 'agents',
        ]);
    }

    public function save()
    {
        [$activeWorkspace] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'];

        $id = $this->request->getPost('id');
        $provider = $this->request->getPost('provider') ?? 'openai';
        $name = trim($this->request->getPost('name') ?? 'AI Specialist');
        $model = trim($this->request->getPost('model') ?? 'gpt-4o');
        $apiKey = trim($this->request->getPost('api_key') ?? '');
        $prompt = trim($this->request->getPost('system_prompt') ?? '');

        $agentModel = new AiAgentModel();

        if ($id) {
            $existing = $agentModel->where('workspace_id', $workspaceId)->find($id);
            if ($existing) {
                $updateData = [
                    'name'          => $name,
                    'model'         => $model,
                    'system_prompt' => $prompt,
                ];
                if (!empty($apiKey) && !str_contains($apiKey, '••••')) {
                    $updateData['api_key'] = $apiKey;
                }
                $agentModel->update($id, $updateData);
                ActivityLogModel::log($workspaceId, session()->get('user_name'), 'Updated AI Agent: ' . $name);
                return redirect()->back()->with('success', 'Agent credentials and prompt updated.');
            }
        }

        // New Agent
        $agentModel->insert([
            'workspace_id'  => $workspaceId,
            'provider'      => $provider,
            'name'          => $name,
            'model'         => $model,
            'api_key'       => $apiKey,
            'system_prompt' => $prompt,
            'status'        => 'active',
            'total_runs'    => 0,
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        ActivityLogModel::log($workspaceId, session()->get('user_name'), 'Added new AI Agent: ' . $name);
        return redirect()->back()->with('success', 'New AI Agent successfully configured!');
    }

    public function testRun($id)
    {
        [$activeWorkspace] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'];

        $agentModel = new AiAgentModel();
        $agent = $agentModel->where('workspace_id', $workspaceId)->find($id);

        if (!$agent) {
            return $this->response->setJSON(['error' => 'Agent not found.']);
        }

        $inputPrompt = trim($this->request->getPost('prompt') ?? 'Generate 3 SEO growth recommendations for high-intent SaaS keywords.');

        // Increment total runs
        $agentModel->update($id, ['total_runs' => (int)$agent['total_runs'] + 1]);

        $mockOutput = "✨ [AI Response from " . esc($agent['name']) . " (" . esc($agent['model']) . ")]\n\n" .
            "1. Pillar Cluster Mapping: Consolidate thin technical guides into a comprehensive authority hub.\n" .
            "2. Semantic Intent Schema: Implement JSON-LD FAQPage and TechArticle structured data with aggregate metrics.\n" .
            "3. Internal Link Architecture: Route anchor equity from top-performing informational assets to commercial conversion endpoints.";

        return $this->response->setJSON([
            'success' => true,
            'agent'   => $agent['name'],
            'model'   => $agent['model'],
            'output'  => $mockOutput,
        ]);
    }
}
