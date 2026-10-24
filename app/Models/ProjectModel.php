<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table            = 'projects';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'workspace_id', 'name', 'department', 'platform', 'objective',
        'audience', 'market', 'website', 'success_metrics', 'knowledge_base', 'status',
        'zip_file', 'deleted_at',
        'version', 'health_score', 'created_at', 'updated_at'
    ];
    protected $useTimestamps    = true;

    public function getProjectsByWorkspace(int $workspaceId, ?string $status = null, ?string $search = null, ?array $allowedProjectIds = null)
    {
        $builder = $this->where('workspace_id', $workspaceId);

        // Filter by assigned project IDs if restricted
        if ($allowedProjectIds !== null) {
            if (empty($allowedProjectIds)) {
                return [];
            }
            $builder->whereIn('id', $allowedProjectIds);
        }

        if ($status === 'deleted' || $status === 'zipped') {
            $builder->where('status', 'deleted');
        } elseif ($status && $status !== 'all') {
            $builder->where('status', $status);
        } else {
            // 'all' excludes deleted/trash projects
            $builder->where('status !=', 'deleted');
        }

        if ($search) {
            $builder->groupStart()
                ->like('name', $search)
                ->orLike('objective', $search)
                ->orLike('market', $search)
                ->groupEnd();
        }

        return $builder->orderBy('updated_at', 'DESC')->findAll();
    }

    public function getProjectCounts(int $workspaceId, ?array $allowedProjectIds = null): array
    {
        if ($allowedProjectIds !== null && empty($allowedProjectIds)) {
            return [
                'all'      => 0,
                'active'   => 0,
                'archived' => 0,
                'deleted'  => 0,
            ];
        }

        $applyAllowed = function($builder) use ($allowedProjectIds) {
            if ($allowedProjectIds !== null) {
                $builder->whereIn('id', $allowedProjectIds);
            }
            return $builder;
        };

        $all = $applyAllowed($this->where('workspace_id', $workspaceId)->where('status !=', 'deleted'))->countAllResults();
        $active = $applyAllowed($this->where('workspace_id', $workspaceId)->where('status', 'active'))->countAllResults();
        $archived = $applyAllowed($this->where('workspace_id', $workspaceId)->where('status', 'archived'))->countAllResults();
        $deleted = $applyAllowed($this->where('workspace_id', $workspaceId)->where('status', 'deleted'))->countAllResults();

        return [
            'all'      => $all,
            'active'   => $active,
            'archived' => $archived,
            'deleted'  => $deleted,
        ];
    }
}
