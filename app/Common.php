<?php

/**
 * Common helper functions for AI Master Agency
 */

if (!function_exists('project_slug')) {
    function project_slug(array|string $name): string
    {
        $raw = is_array($name) ? ($name['name'] ?? '') : (string)$name;
        $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $raw), '-'));
        return $slug;
    }
}

if (!function_exists('project_url')) {
    function project_url(array|int|string $project, string $tab = ''): string
    {
        if (is_array($project)) {
            $slug = project_slug($project['name'] ?? '');
            $param = !empty($slug) ? $slug : ($project['id'] ?? '');
        } elseif (is_numeric($project)) {
            $param = (string)$project;
        } else {
            $param = project_slug((string)$project);
        }
        $url = site_url('projects/' . $param);
        if ($tab !== '') {
            $url .= '#' . ltrim($tab, '#');
        }
        return $url;
    }
}

if (!function_exists('is_client_user')) {
    function is_client_user(): bool
    {
        $memberType = session()->get('member_type') ?? '';
        $role = session()->get('workspace_role') ?? (session()->get('user_role') ?? '');
        return ($memberType === 'client' || str_starts_with($role, 'client'));
    }
}

if (!function_exists('is_admin_user')) {
    function is_admin_user(): bool
    {
        $role = session()->get('workspace_role') ?? (session()->get('user_role') ?? '');
        return in_array($role, ['owner', 'admin']);
    }
}

if (!function_exists('get_user_accessible_project_ids')) {
    function get_user_accessible_project_ids(?int $userId = null, ?int $workspaceId = null): ?array
    {
        $userId = $userId ?? session()->get('user_id');
        $workspaceId = $workspaceId ?? session()->get('workspace_id');

        if (!$userId || !$workspaceId) {
            return [];
        }

        // Owners and Admins have access to ALL projects in workspace
        if (is_admin_user()) {
            return null; // null means unrestricted in workspace
        }

        $db = \Config\Database::connect();

        // 1. Check project_members table
        $pmRows = $db->table('project_members')
            ->select('project_members.project_id')
            ->join('projects', 'projects.id = project_members.project_id')
            ->where('project_members.user_id', $userId)
            ->where('projects.workspace_id', $workspaceId)
            ->get()
            ->getResultArray();

        $projectIds = array_column($pmRows, 'project_id');

        // 2. Also check workspace_members.project_id (direct single project link)
        $wmRow = $db->table('workspace_members')
            ->select('project_id')
            ->where('workspace_id', $workspaceId)
            ->where('user_id', $userId)
            ->where('project_id IS NOT NULL')
            ->get()
            ->getRowArray();

        if (!empty($wmRow['project_id']) && !in_array($wmRow['project_id'], $projectIds)) {
            $projectIds[] = (int)$wmRow['project_id'];
        }

        return array_map('intval', array_unique($projectIds));
    }
}

if (!function_exists('can_user_access_project')) {
    function can_user_access_project(int $projectId, ?int $userId = null, ?int $workspaceId = null): bool
    {
        $userId = $userId ?? session()->get('user_id');
        $workspaceId = $workspaceId ?? session()->get('workspace_id');

        if (!$userId || !$workspaceId) {
            return false;
        }

        if (is_admin_user()) {
            // Verify project belongs to workspace
            $db = \Config\Database::connect();
            $cnt = $db->table('projects')->where('id', $projectId)->where('workspace_id', $workspaceId)->countAllResults();
            return ($cnt > 0);
        }

        $allowedIds = get_user_accessible_project_ids($userId, $workspaceId);
        return in_array($projectId, $allowedIds);
    }
}
