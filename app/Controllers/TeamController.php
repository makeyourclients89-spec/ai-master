<?php

namespace App\Controllers;

use App\Models\WorkspaceModel;
use App\Models\UserModel;
use App\Models\ProjectModel;
use App\Models\ActivityLogModel;

class TeamController extends BaseController
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
            return redirect()->to(site_url('dashboard'))->with('error', 'Access restricted: Team management is reserved for agency staff.');
        }

        [$activeWorkspace, $workspaces] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'];

        $db = \Config\Database::connect();
        $members = $db->table('workspace_members')
            ->select('workspace_members.id as membership_id, workspace_members.role as member_role, workspace_members.member_type, workspace_members.designation, workspace_members.company_name, workspace_members.project_id, users.id as user_id, users.name, users.email, users.avatar, workspace_members.created_at, projects.name as project_name')
            ->join('users', 'users.id = workspace_members.user_id')
            ->join('projects', 'projects.id = workspace_members.project_id', 'left')
            ->where('workspace_members.workspace_id', $workspaceId)
            ->orderBy('workspace_members.id', 'ASC')
            ->get()
            ->getResultArray();

        // Normalize any NULL member_type based on role
        foreach ($members as &$m) {
            if (empty($m['member_type'])) {
                if (str_starts_with($m['member_role'] ?? '', 'client')) {
                    $m['member_type'] = 'client';
                } else {
                    $m['member_type'] = 'employee';
                }
            }
        }
        unset($m);

        // Fetch workspace projects for dropdown assignment
        $projectModel = new ProjectModel();
        $projects = $projectModel->where('workspace_id', $workspaceId)->findAll();

        return view('team/index', [
            'activeWorkspace' => $activeWorkspace,
            'workspaces'      => $workspaces,
            'members'         => $members,
            'projects'        => $projects,
            'title'           => 'People & Access',
            'currentPage'     => 'team',
        ]);
    }

    public function addMember()
    {
        if (is_client_user()) {
            return redirect()->to(site_url('dashboard'))->with('error', 'Access restricted: Only agency staff can add team members or clients.');
        }

        [$activeWorkspace] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'];

        $name = trim($this->request->getPost('name') ?? '');
        $email = trim($this->request->getPost('email') ?? '');
        $memberType = $this->request->getPost('member_type') ?? 'employee';
        if (!in_array($memberType, ['employee', 'client'])) {
            $memberType = 'employee';
        }

        $role = $this->request->getPost('role') ?? ($memberType === 'client' ? 'client_approver' : 'member');
        $designation = trim($this->request->getPost('designation') ?? '');
        $companyName = trim($this->request->getPost('company_name') ?? '');
        $projectId = $this->request->getPost('project_id');

        if (empty($name) || empty($email)) {
            return redirect()->back()->with('error', 'Name and Email are required.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        $db = \Config\Database::connect();

        if (!$user) {
            // Direct create user account without sending email friction
            $userId = $userModel->insert([
                'name'       => $name,
                'email'      => $email,
                'password'   => password_hash('welcome123', PASSWORD_DEFAULT),
                'role'       => $role,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            $userId = $user['id'];
        }

        // Check if already member of this workspace
        $exists = $db->table('workspace_members')
            ->where('workspace_id', $workspaceId)
            ->where('user_id', $userId)
            ->countAllResults();

        if ($exists > 0) {
            return redirect()->back()->with('error', 'This user is already a member of this workspace.');
        }

        // If client and project specified, auto-fill company name if empty
        if ($memberType === 'client' && !empty($projectId) && empty($companyName)) {
            $proj = (new ProjectModel())->find($projectId);
            if ($proj) {
                $companyName = $proj['name'];
            }
        }

        $db->table('workspace_members')->insert([
            'workspace_id' => $workspaceId,
            'user_id'      => $userId,
            'role'         => $role,
            'member_type'  => $memberType,
            'designation'  => !empty($designation) ? $designation : ($memberType === 'client' ? 'Client Stakeholder' : 'Team Member'),
            'company_name' => !empty($companyName) ? $companyName : ($memberType === 'client' ? 'Client Partner' : 'Agency'),
            'project_id'   => !empty($projectId) ? (int)$projectId : null,
            'created_at'   => date('Y-m-d H:i:s'),
        ]);

        // Also record in project_members if assigned to a project
        if (!empty($projectId)) {
            $db->table('project_members')->ignore(true)->insert([
                'project_id' => (int)$projectId,
                'user_id'    => $userId,
                'role'       => $role,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $label = $memberType === 'client' ? 'Client Stakeholder' : 'Agency Employee';
        ActivityLogModel::log($workspaceId, session()->get('user_name') ?? 'Admin', "Added $label: $name ($email)");

        return redirect()->back()->with('success', "$label '$name' ($email) has been added successfully!");
    }

    public function removeMember($membershipId)
    {
        [$activeWorkspace] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'];

        $db = \Config\Database::connect();
        $member = $db->table('workspace_members')->where('id', $membershipId)->where('workspace_id', $workspaceId)->get()->getRowArray();

        if ($member && $member['role'] !== 'owner') {
            $db->table('workspace_members')->where('id', $membershipId)->delete();
            ActivityLogModel::log($workspaceId, session()->get('user_name') ?? 'Admin', 'Removed team member access');
            return redirect()->back()->with('success', 'Member access removed from workspace.');
        }

        return redirect()->back()->with('error', 'Cannot remove workspace owner.');
    }
}
