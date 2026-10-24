<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkspaceModel extends Model
{
    protected $table            = 'workspaces';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['name', 'slug', 'owner_id', 'created_at', 'updated_at'];
    protected $useTimestamps    = true;

    public function getUserWorkspaces(int $userId)
    {
        $db = \Config\Database::connect();
        return $db->table('workspaces')
            ->select('workspaces.*, workspace_members.role, workspace_members.member_type, workspace_members.designation, workspace_members.company_name, workspace_members.project_id')
            ->join('workspace_members', 'workspace_members.workspace_id = workspaces.id')
            ->where('workspace_members.user_id', $userId)
            ->orderBy('workspaces.created_at', 'ASC')
            ->get()
            ->getResultArray();
    }
}
