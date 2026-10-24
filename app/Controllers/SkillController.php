<?php

namespace App\Controllers;

use App\Models\WorkspaceModel;
use App\Models\SkillModel;
use App\Models\ProjectModel;
use App\Models\ActivityLogModel;

class SkillController extends BaseController
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
            return redirect()->to(site_url('dashboard'))->with('error', 'Access restricted: Skills & SOPs Library is reserved for agency staff.');
        }

        [$activeWorkspace, $workspaces] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'] ?? null;

        $category = trim($this->request->getGet('category') ?? 'all');
        $search = trim($this->request->getGet('q') ?? '');

        $skillModel = new SkillModel();
        $skills = $skillModel->getGlobalSkills($workspaceId, $category, $search);

        // Calculate counts by category
        $allGlobal = $skillModel->where('is_global', 1)->where('project_id', null)->findAll();
        $counts = ['all' => count($allGlobal)];
        foreach ($allGlobal as $s) {
            $cat = strtolower($s['category']);
            $counts[$cat] = ($counts[$cat] ?? 0) + 1;
        }

        return view('skills/index', [
            'activeWorkspace' => $activeWorkspace,
            'workspaces'      => $workspaces,
            'skills'          => $skills,
            'category'        => $category,
            'search'          => $search,
            'counts'          => $counts,
            'title'           => 'Agency Skills & Frameworks Library',
            'currentPage'     => 'skills',
        ]);
    }

    public function create()
    {
        [$activeWorkspace] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'] ?? null;

        $name = trim($this->request->getPost('name') ?? '');
        $category = strtolower(trim($this->request->getPost('category') ?? 'seo'));
        $level = trim($this->request->getPost('level') ?? 'advanced');
        $accuracy = trim($this->request->getPost('accuracy') ?? '99.4%');
        $estimatedTime = trim($this->request->getPost('estimated_time') ?? '15-30 Mins');
        $description = trim($this->request->getPost('description') ?? '');
        $inputs = trim($this->request->getPost('inputs_required') ?? '');
        $example = trim($this->request->getPost('example_scenario') ?? '');
        $content = trim($this->request->getPost('content') ?? '');

        if (empty($name)) {
            return redirect()->back()->withInput()->with('error', 'Skill name is required.');
        }

        $slug = url_title($name, '-', true);
        if (empty($slug)) {
            $slug = 'skill-' . time();
        }

        $folder = FCPATH . '../skills/' . $category . '/';
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $fileName = $slug . '.md';
        $relPath = 'skills/' . $category . '/' . $fileName;
        $fullPath = FCPATH . '../' . $relPath;

        if (empty($content)) {
            $content = "# " . $name . "\n\n**Category:** " . strtoupper($category) . "\n**Level:** " . ucfirst($level) . "\n**Accuracy:** " . $accuracy . "\n**Estimated Time:** " . $estimatedTime . "\n\n" . $description;
            if (!empty($inputs)) {
                $content .= "\n\n## Required Inputs\n" . $inputs;
            }
            if (!empty($example)) {
                $content .= "\n\n## Example & Expected Scenario\n" . $example;
            }
        }

        file_put_contents($fullPath, $content);

        $skillModel = new SkillModel();
        $skillModel->insert([
            'workspace_id'     => $workspaceId,
            'project_id'       => null,
            'name'             => $name,
            'slug'             => $slug,
            'category'         => $category,
            'level'            => $level,
            'accuracy'         => $accuracy,
            'estimated_time'   => $estimatedTime,
            'folder_path'      => $relPath,
            'description'      => $description,
            'inputs_required'  => $inputs,
            'example_scenario' => $example,
            'content'          => $content,
            'is_global'        => 1,
            'status'           => 'active',
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
        ]);

        ActivityLogModel::log($workspaceId, session()->get('user_name'), 'Created global skill: ' . $name, 'Skills/' . $category);

        return redirect()->to(site_url('skills/'))->with('success', 'Global skill "' . esc($name) . '" created successfully in folder ' . $relPath . '!');
    }

    public function update($id)
    {
        [$activeWorkspace] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'] ?? null;

        $skillModel = new SkillModel();
        $skill = $skillModel->find($id);

        if (!$skill) {
            return redirect()->back()->with('error', 'Skill not found.');
        }

        $name = trim($this->request->getPost('name') ?? '');
        $category = strtolower(trim($this->request->getPost('category') ?? $skill['category']));
        $level = trim($this->request->getPost('level') ?? $skill['level']);
        $accuracy = trim($this->request->getPost('accuracy') ?? ($skill['accuracy'] ?? '99.4%'));
        $estimatedTime = trim($this->request->getPost('estimated_time') ?? ($skill['estimated_time'] ?? '15-30 Mins'));
        $description = trim($this->request->getPost('description') ?? '');
        $inputs = trim($this->request->getPost('inputs_required') ?? '');
        $example = trim($this->request->getPost('example_scenario') ?? '');
        $content = trim($this->request->getPost('content') ?? '');

        if (empty($name)) {
            return redirect()->back()->withInput()->with('error', 'Skill name is required.');
        }

        // Folder & File management
        $oldRelPath = $skill['folder_path'];
        $folder = FCPATH . '../skills/' . $category . '/';
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $slug = url_title($name, '-', true);
        if (empty($slug)) {
            $slug = $skill['slug'] ?: ('skill-' . time());
        }

        $fileName = $slug . '.md';
        if (!empty($skill['project_id'])) {
            $fileName = 'project_' . $skill['project_id'] . '_' . $slug . '.md';
        }
        $newRelPath = 'skills/' . $category . '/' . $fileName;

        // If path changed, remove old file
        if (!empty($oldRelPath) && $oldRelPath !== $newRelPath) {
            $oldFullPath = FCPATH . '../' . $oldRelPath;
            if (is_file($oldFullPath)) {
                @unlink($oldFullPath);
            }
        }

        $fullPath = FCPATH . '../' . $newRelPath;
        file_put_contents($fullPath, $content);

        $skillModel->update($id, [
            'name'             => $name,
            'slug'             => $slug,
            'category'         => $category,
            'level'            => $level,
            'accuracy'         => $accuracy,
            'estimated_time'   => $estimatedTime,
            'folder_path'      => $newRelPath,
            'description'      => $description,
            'inputs_required'  => $inputs,
            'example_scenario' => $example,
            'content'          => $content,
            'updated_at'       => date('Y-m-d H:i:s'),
        ]);

        ActivityLogModel::log($workspaceId, session()->get('user_name'), 'Updated skill: ' . $name, 'Skills/' . $category);

        return redirect()->back()->with('success', 'Skill "' . esc($name) . '" updated successfully!');
    }

    public function createProjectSkill($projectId)
    {
        [$activeWorkspace] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'] ?? null;

        $projectModel = new ProjectModel();
        $project = $projectModel->where('workspace_id', $workspaceId)->find($projectId);
        if (!$project) {
            return redirect()->to(site_url('projects'))->with('error', 'Project not found.');
        }

        $name = trim($this->request->getPost('name') ?? '');
        $category = strtolower(trim($this->request->getPost('category') ?? 'custom'));
        $level = trim($this->request->getPost('level') ?? 'custom');
        $description = trim($this->request->getPost('description') ?? '');
        $inputs = trim($this->request->getPost('inputs_required') ?? '');
        $example = trim($this->request->getPost('example_scenario') ?? '');
        $content = trim($this->request->getPost('content') ?? '');

        if (empty($name)) {
            return redirect()->back()->withInput()->with('error', 'Custom skill name is required.');
        }

        $slug = url_title($name, '-', true);
        if (empty($slug)) {
            $slug = 'custom-skill-' . time();
        }

        $folder = FCPATH . '../skills/' . $category . '/';
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $fileName = 'project_' . $projectId . '_' . $slug . '.md';
        $relPath = 'skills/' . $category . '/' . $fileName;
        $fullPath = FCPATH . '../' . $relPath;

        if (empty($content)) {
            $content = "# " . $name . "\n\n**Project:** " . $project['name'] . "\n**Category:** " . strtoupper($category) . "\n\n" . $description;
            if (!empty($inputs)) {
                $content .= "\n\n## Required Inputs\n" . $inputs;
            }
            if (!empty($example)) {
                $content .= "\n\n## Example & Expected Scenario\n" . $example;
            }
        }

        file_put_contents($fullPath, $content);

        $skillModel = new SkillModel();
        $skillModel->insert([
            'workspace_id'     => $workspaceId,
            'project_id'       => $projectId,
            'name'             => $name,
            'slug'             => $slug,
            'category'         => $category,
            'level'            => $level,
            'folder_path'      => $relPath,
            'description'      => $description,
            'inputs_required'  => $inputs,
            'example_scenario' => $example,
            'content'          => $content,
            'is_global'        => 0,
            'status'           => 'active',
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
        ]);

        ActivityLogModel::log($workspaceId, session()->get('user_name'), 'Added custom skill for project ' . $project['name'] . ': ' . $name, 'Project #' . $projectId);

        return redirect()->back()->with('success', 'Custom skill "' . esc($name) . '" saved for this project in ' . $relPath . '!');
    }

    public function delete($id)
    {
        [$activeWorkspace] = $this->getActiveWorkspace();
        $workspaceId = $activeWorkspace['id'] ?? null;

        $skillModel = new SkillModel();
        $skill = $skillModel->find($id);

        if (!$skill) {
            return redirect()->back()->with('error', 'Skill not found.');
        }

        if (!empty($skill['folder_path'])) {
            $fullPath = FCPATH . '../' . $skill['folder_path'];
            if (is_file($fullPath)) {
                @unlink($fullPath);
            }
        }

        $skillModel->delete($id);
        ActivityLogModel::log($workspaceId, session()->get('user_name'), 'Deleted skill: ' . $skill['name']);

        return redirect()->back()->with('success', 'Skill "' . esc($skill['name']) . '" deleted successfully.');
    }

    public function apiGet($id)
    {
        $skillModel = new SkillModel();
        $skill = $skillModel->find($id);

        if (!$skill) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Skill not found'])->setStatusCode(404);
        }

        // Try reading latest file content from disk if available
        if (!empty($skill['folder_path'])) {
            $fullPath = FCPATH . '../' . $skill['folder_path'];
            if (file_exists($fullPath)) {
                $skill['content'] = file_get_contents($fullPath);
            }
        }

        return $this->response->setJSON([
            'status' => 'success',
            'skill'  => $skill
        ]);
    }
}
