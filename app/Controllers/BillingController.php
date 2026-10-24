<?php

namespace App\Controllers;

use App\Models\WorkspaceModel;

class BillingController extends BaseController
{
    public function index()
    {
        if (is_client_user()) {
            return redirect()->to(site_url('dashboard'))->with('error', 'Access restricted: Billing is reserved for workspace administrators.');
        }

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

        return view('billing/index', [
            'activeWorkspace' => $activeWorkspace,
            'workspaces'      => $workspaces,
            'title'           => 'Plan & Usage',
            'currentPage'     => 'billing',
        ]);
    }
}
