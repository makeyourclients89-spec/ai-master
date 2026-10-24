<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\WorkspaceModel;
use App\Models\ConnectorModel;
use App\Models\GscProjectMappingModel;
use App\Models\GscPropertyModel;
use App\Models\ActivityLogModel;
use App\Services\GoogleSearchConsoleService;

class GoogleSearchConsoleController extends BaseController
{
    protected GoogleSearchConsoleService $gscService;

    public function __construct()
    {
        $this->gscService = new GoogleSearchConsoleService();
    }

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

    /**
     * Start Google OAuth Flow
     */
    public function connect($projectId)
    {
        [$activeWorkspace] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'];

        $projectModel = new ProjectModel();
        $project = $projectModel->where('workspace_id', $workspaceId)->find($projectId);
        if (!$project) {
            return redirect()->to(site_url('projects'))->with('error', 'Project not found.');
        }

        $authUrl = $this->gscService->getAuthUrl((int)$projectId);
        return redirect()->to($authUrl);
    }

    /**
     * Handle Google OAuth Callback
     */
    public function callback()
    {
        [$activeWorkspace] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'];
        $userId = session()->get('user_id') ?: 1;

        $code  = $this->request->getGet('code');
        $state = $this->request->getGet('state');
        $error = $this->request->getGet('error');

        $projectId = null;
        if (!empty($state)) {
            $decodedState = json_decode(base64_decode($state), true);
            $projectId = $decodedState['project_id'] ?? null;
        }

        if ($error || !$code) {
            $msg = 'Google Authorization cancelled or failed: ' . ($error ?: 'Missing code');
            $redirectUrl = $projectId ? site_url('projects/' . $projectId . '#tabConnectors') : site_url('projects');
            return redirect()->to($redirectUrl)->with('error', $msg);
        }

        // Exchange code
        $tokenData = $this->gscService->exchangeCode($code);
        if (!$tokenData['success']) {
            $redirectUrl = $projectId ? site_url('projects/' . $projectId . '#tabConnectors') : site_url('projects');
            return redirect()->to($redirectUrl)->with('error', 'Token Exchange Failed: ' . $tokenData['error']);
        }

        // Fetch User Info
        $userInfo = $this->gscService->getUserInfo($tokenData['access_token']);

        // Fetch Properties
        $properties = $this->gscService->fetchPropertiesFromGoogle($tokenData['access_token']);

        // Record Connection
        $this->gscService->recordConnection(
            (int)$workspaceId,
            (int)$userId,
            $userInfo['email'],
            $userInfo['name'],
            $userInfo['picture'],
            $tokenData['access_token'],
            $tokenData['refresh_token'] ?? null,
            (int)$tokenData['expires_in'],
            $properties,
            (int)$projectId
        );

        ActivityLogModel::log($workspaceId, session()->get('user_name'), 'Connected Google Search Console account: ' . $userInfo['email'], 'Project #' . $projectId);

        $redirectUrl = $projectId ? site_url('projects/' . $projectId . '#tabConnectors') : site_url('projects');
        return redirect()->to($redirectUrl)->with('success', '⚡ Google Search Console successfully connected for ' . esc($userInfo['email']) . '!');
    }

    /**
     * Map a selected Property to Project
     */
    public function mapProperty($projectId)
    {
        [$activeWorkspace] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'];

        $projectModel = new ProjectModel();
        $project = $projectModel->where('workspace_id', $workspaceId)->find($projectId);
        if (!$project) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Project not found']);
        }

        $propertyId = (int)$this->request->getPost('property_id');
        $success = $this->gscService->mapPropertyToProject((int)$projectId, $propertyId);

        if ($success) {
            ActivityLogModel::log($workspaceId, session()->get('user_name'), 'Mapped GSC property to project', 'Project #' . $projectId);
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Google Search Console property mapped & metrics synced!'
            ]);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to map property']);
    }

    /**
     * Get JSON Performance Analytics
     */
    public function getPerformance($projectId)
    {
        [$activeWorkspace] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'];

        $projectModel = new ProjectModel();
        $project = $projectModel->where('workspace_id', $workspaceId)->find($projectId);
        if (!$project) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Project not found']);
        }

        $range = $this->request->getGet('range') ?: '28d';
        $analytics = $this->gscService->getProjectAnalytics((int)$projectId, $range);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $analytics
        ]);
    }

    /**
     * Sync Search Analytics
     */
    public function sync($projectId)
    {
        [$activeWorkspace] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'];

        $projectModel = new ProjectModel();
        $project = $projectModel->where('workspace_id', $workspaceId)->find($projectId);
        if (!$project) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Project not found']);
        }

        $mapModel  = new GscProjectMappingModel();
        $propModel = new GscPropertyModel();

        $mapping = $mapModel->where('project_id', $projectId)->where('is_active', 1)->first();
        if (!$mapping) {
            // Auto connect fallback or get first property
            $prop = $propModel->first();
            $propertyId = $prop ? $prop['id'] : 1;
            $siteUrl = !empty($project['website']) ? $project['website'] : 'https://wsadigitalagency.com/';
        } else {
            $propertyId = $mapping['property_id'];
            $prop = $propModel->find($propertyId);
            $siteUrl = $prop ? $prop['site_url'] : $project['website'];
        }

        $res = $this->gscService->syncSearchAnalytics((int)$projectId, $siteUrl, (int)$propertyId);

        ActivityLogModel::log($workspaceId, session()->get('user_name'), 'Synced Google Search Console analytics for ' . $siteUrl, 'Project #' . $projectId);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => '⚡ Google Search Console analytics synced! ' . number_format($res['total_clicks']) . ' clicks & ' . number_format($res['total_impressions']) . ' impressions updated.',
            'data'    => $res
        ]);
    }

    /**
     * Disconnect Search Console
     */
    public function disconnect($projectId)
    {
        [$activeWorkspace] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'];

        $projectModel = new ProjectModel();
        $project = $projectModel->where('workspace_id', $workspaceId)->find($projectId);
        if (!$project) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Project not found']);
        }

        $mapModel = new GscProjectMappingModel();
        $mapModel->where('project_id', $projectId)->delete();

        $connModel = new ConnectorModel();
        $connModel->where('project_id', $projectId)->where('type', 'google_search_console')->delete();

        ActivityLogModel::log($workspaceId, session()->get('user_name'), 'Disconnected Google Search Console', 'Project #' . $projectId);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Google Search Console connection removed.'
        ]);
    }
}
