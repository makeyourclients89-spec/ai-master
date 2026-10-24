<?php

namespace App\Controllers;

use App\Models\WorkspaceModel;
use App\Models\ActivityLogModel;

class ActivityController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $workspaceModel = new WorkspaceModel();
        $workspaces = $workspaceModel->getUserWorkspaces($userId);
        $activeId = session()->get('workspace_id');
        $activeWorkspace = null;
        foreach ($workspaces as $ws) {
            if ($ws['id'] == $activeId) {
                $activeWorkspace = $ws;
                break;
            }
        }
        if (!$activeWorkspace && !empty($workspaces)) {
            $activeWorkspace = $workspaces[0];
        }

        $workspaceId = $activeWorkspace['id'];
        $activityLogModel = new ActivityLogModel();
        $activities = $activityLogModel->where('workspace_id', $workspaceId)->orderBy('created_at', 'DESC')->findAll(50);

        return view('activity/index', [
            'activeWorkspace' => $activeWorkspace,
            'workspaces'      => $workspaces,
            'activities'      => $activities,
            'title'           => 'Workspace Activity Log',
            'currentPage'     => 'activity',
        ]);
    }
}
