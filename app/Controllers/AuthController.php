<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\WorkspaceModel;
use App\Models\ActivityLogModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(site_url('dashboard'));
        }
        return view('auth/login');
    }

    public function loginSubmit()
    {
        $email = trim($this->request->getPost('email') ?? '');
        $password = $this->request->getPost('password') ?? '';

        if (empty($email) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Please enter your email and password.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password. Please try again.');
        }

        // Fetch workspace
        $workspaceModel = new WorkspaceModel();
        $workspaces = $workspaceModel->getUserWorkspaces($user['id']);

        $activeWorkspace = null;
        if (!empty($workspaces)) {
            $activeWorkspace = $workspaces[0];
        } else {
            // Auto create workspace if none exists
            $wsId = $workspaceModel->insert([
                'name'     => $user['name'] . "'s Workspace",
                'slug'     => url_title($user['name'] . ' workspace', '-', true),
                'owner_id' => $user['id'],
            ]);
            $db = \Config\Database::connect();
            $db->table('workspace_members')->insert([
                'workspace_id' => $wsId,
                'user_id'      => $user['id'],
                'role'         => 'owner',
                'created_at'   => date('Y-m-d H:i:s'),
            ]);
            $activeWorkspace = [
                'id'   => $wsId,
                'name' => $user['name'] . "'s Workspace",
                'role' => 'owner',
            ];
        }

        $memberType = $activeWorkspace['member_type'] ?? (str_starts_with($activeWorkspace['role'] ?? '', 'client') ? 'client' : 'employee');
        $workspaceRole = $activeWorkspace['role'] ?? ($user['role'] ?? 'owner');

        // Direct Login without any email verification
        session()->set([
            'logged_in'           => true,
            'user_id'             => $user['id'],
            'user_name'           => $user['name'],
            'user_email'          => $user['email'],
            'user_role'           => $user['role'] ?? 'owner',
            'member_type'         => $memberType,
            'designation'         => $activeWorkspace['designation'] ?? '',
            'company_name'        => $activeWorkspace['company_name'] ?? '',
            'assigned_project_id' => $activeWorkspace['project_id'] ?? null,
            'workspace_id'        => $activeWorkspace['id'],
            'workspace_name'      => $activeWorkspace['name'],
            'workspace_role'      => $workspaceRole,
        ]);

        ActivityLogModel::log($activeWorkspace['id'], $user['name'], 'Signed in to dashboard');

        return redirect()->to(site_url('dashboard'))->with('success', 'Welcome back, ' . esc($user['name']) . '!');
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(site_url('dashboard'));
        }
        return view('auth/register');
    }

    public function registerSubmit()
    {
        $name = trim($this->request->getPost('name') ?? '');
        $email = trim($this->request->getPost('email') ?? '');
        $password = $this->request->getPost('password') ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'All fields are required.');
        }

        if (strlen($password) < 6) {
            return redirect()->back()->withInput()->with('error', 'Password must be at least 6 characters.');
        }

        $userModel = new UserModel();
        if ($userModel->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'An account with this email already exists. Please sign in.');
        }

        // Create User
        $userId = $userModel->insert([
            'name'       => $name,
            'email'      => $email,
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'role'       => 'owner',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Auto Create Workspace
        $workspaceModel = new WorkspaceModel();
        $wsName = $name . "'s Agency";
        $wsId = $workspaceModel->insert([
            'name'       => $wsName,
            'slug'       => url_title($wsName, '-', true),
            'owner_id'   => $userId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Add to workspace members
        $db = \Config\Database::connect();
        $db->table('workspace_members')->insert([
            'workspace_id' => $wsId,
            'user_id'      => $userId,
            'role'         => 'owner',
            'created_at'   => date('Y-m-d H:i:s'),
        ]);

        // Add default sample project so dashboard is immediately ready
        $db->table('projects')->insert([
            'workspace_id'    => $wsId,
            'name'            => 'Website Growth & Strategy',
            'department'      => 'seo',
            'platform'        => 'wordpress',
            'objective'       => 'Scale organic reach, improve technical Core Web Vitals, and generate inbound sales leads.',
            'audience'        => 'Target B2B & Enterprise Clients',
            'market'          => 'India & Global',
            'website'         => 'https://example.com',
            'success_metrics' => '100k+ Monthly Visits, 90+ PageSpeed Score, 50+ Qualified Inquiries/mo',
            'status'          => 'active',
            'health_score'    => 95,
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
        ]);

        // Direct Login without any email verification or sending!
        session()->set([
            'logged_in'      => true,
            'user_id'        => $userId,
            'user_name'      => $name,
            'user_email'     => $email,
            'user_role'      => 'owner',
            'workspace_id'   => $wsId,
            'workspace_name' => $wsName,
            'workspace_role' => 'owner',
        ]);

        ActivityLogModel::log($wsId, $name, 'Created account and launched workspace');

        return redirect()->to(site_url('dashboard'))->with('success', 'Account created successfully! Welcome to your AI Agency dashboard.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('login'))->with('success', 'You have been signed out.');
    }
}
