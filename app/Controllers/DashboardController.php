<?php

namespace App\Controllers;

use App\Models\WorkspaceModel;
use App\Models\ProjectModel;
use App\Models\ProjectTaskModel;
use App\Models\AiAgentModel;
use App\Models\ActivityLogModel;
use App\Models\NotificationModel;

class DashboardController extends BaseController
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
            session()->set([
                'workspace_id'   => $active['id'],
                'workspace_name' => $active['name'],
                'workspace_role' => $active['role'] ?? 'owner',
            ]);
        }

        return [$active, $workspaces];
    }

    public function index()
    {
        [$activeWorkspace, $workspaces] = $this->getActiveWorkspace();

        if (!$activeWorkspace) {
            return redirect()->to(site_url('login'));
        }

        $workspaceId = $activeWorkspace['id'];
        $userId = session()->get('user_id');
        $allowedProjectIds = get_user_accessible_project_ids($userId, $workspaceId);

        $projectModel = new ProjectModel();
        if ($allowedProjectIds !== null) {
            $projects = !empty($allowedProjectIds) 
                ? $projectModel->where('workspace_id', $workspaceId)->whereIn('id', $allowedProjectIds)->orderBy('updated_at', 'DESC')->findAll()
                : [];
        } else {
            $projects = $projectModel->where('workspace_id', $workspaceId)->orderBy('updated_at', 'DESC')->findAll();
        }

        $activeProjects = array_filter($projects, fn($p) => $p['status'] === 'active');
        $archivedProjects = array_filter($projects, fn($p) => $p['status'] === 'archived');

        // Tasks stats
        $db = \Config\Database::connect();
        $taskBuilder = $db->table('project_tasks')
            ->select('project_tasks.status, count(*) as cnt')
            ->join('projects', 'projects.id = project_tasks.project_id')
            ->where('projects.workspace_id', $workspaceId);

        if ($allowedProjectIds !== null) {
            if (!empty($allowedProjectIds)) {
                $taskBuilder->whereIn('projects.id', $allowedProjectIds);
            } else {
                $taskBuilder->where('1 = 0');
            }
        }

        $taskStats = $taskBuilder->groupBy('project_tasks.status')->get()->getResultArray();

        $tasksTotal = 0;
        $tasksCompleted = 0;
        foreach ($taskStats as $st) {
            $tasksTotal += (int)$st['cnt'];
            if ($st['status'] === 'completed' || $st['status'] === 'approved') {
                $tasksCompleted += (int)$st['cnt'];
            }
        }

        // AI Agents
        $aiAgentModel = new AiAgentModel();
        $agents = $aiAgentModel->where('workspace_id', $workspaceId)->findAll();

        // Recent Activity
        $activityLogModel = new ActivityLogModel();
        $activities = $activityLogModel->where('workspace_id', $workspaceId)->orderBy('created_at', 'DESC')->findAll(8);

        // Notifications
        $notifModel = new NotificationModel();
        $notifications = $notifModel->where('workspace_id', $workspaceId)->orderBy('created_at', 'DESC')->findAll(5);

        // Health score average (Dynamic: 0 if no active projects)
        $avgHealth = 0;
        if (!empty($activeProjects)) {
            $scores = array_filter(array_column($activeProjects, 'health_score'), fn($s) => is_numeric($s));
            $avgHealth = !empty($scores) ? round(array_sum($scores) / count($scores)) : 0;
        }

        $pageTitle = is_client_user() ? 'Client Stakeholder Portal' : (is_admin_user() ? 'Agency Command Center' : 'Specialist Project Hub');

        return view('dashboard/index', [
            'activeWorkspace'  => $activeWorkspace,
            'workspaces'       => $workspaces,
            'projects'         => $projects,
            'activeProjects'   => $activeProjects,
            'archivedProjects' => $archivedProjects,
            'tasksTotal'       => $tasksTotal,
            'tasksCompleted'   => $tasksCompleted,
            'agents'           => $agents,
            'activities'       => $activities,
            'notifications'    => $notifications,
            'avgHealth'        => $avgHealth,
            'title'            => $pageTitle,
            'currentPage'      => 'dashboard',
            'isClient'         => is_client_user(),
        ]);
    }

    public function switchWorkspace($id)
    {
        $userId = session()->get('user_id');
        $workspaceModel = new WorkspaceModel();
        $workspaces = $workspaceModel->getUserWorkspaces($userId);

        foreach ($workspaces as $ws) {
            if ($ws['id'] == $id) {
                session()->set([
                    'workspace_id'   => $ws['id'],
                    'workspace_name' => $ws['name'],
                    'workspace_role' => $ws['role'] ?? 'owner',
                ]);
                return redirect()->back()->with('success', 'Switched to workspace: ' . esc($ws['name']));
            }
        }

        return redirect()->back()->with('error', 'Workspace not found.');
    }

    public function createWorkspace()
    {
        $name = trim($this->request->getPost('name') ?? '');
        if (empty($name)) {
            return redirect()->back()->with('error', 'Workspace name is required.');
        }

        $userId = session()->get('user_id');
        $workspaceModel = new WorkspaceModel();
        $wsId = $workspaceModel->insert([
            'name'     => $name,
            'slug'     => url_title($name, '-', true),
            'owner_id' => $userId,
        ]);

        $db = \Config\Database::connect();
        $db->table('workspace_members')->insert([
            'workspace_id' => $wsId,
            'user_id'      => $userId,
            'role'         => 'owner',
            'created_at'   => date('Y-m-d H:i:s'),
        ]);

        session()->set([
            'workspace_id'   => $wsId,
            'workspace_name' => $name,
            'workspace_role' => 'owner',
        ]);

        ActivityLogModel::log($wsId, session()->get('user_name'), 'Created new workspace: ' . $name);

        return redirect()->to(site_url('dashboard'))->with('success', 'New workspace created and activated!');
    }
}
