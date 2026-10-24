<?php

namespace App\Models;

use CodeIgniter\Model;

class SkillModel extends Model
{
    protected $table            = 'skills';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'workspace_id',
        'project_id',
        'name',
        'slug',
        'category',
        'level',
        'accuracy',
        'estimated_time',
        'folder_path',
        'description',
        'inputs_required',
        'example_scenario',
        'content',
        'execution_steps',
        'is_global',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * Get all global skills plus skills created for a specific workspace
     */
    public function getGlobalSkills(?int $workspaceId = null, string $category = 'all', string $search = '')
    {
        $builder = $this->builder();
        $builder->groupStart()
            ->where('is_global', 1)
            ->where('project_id', null);
            
        if ($workspaceId) {
            $builder->orGroupStart()
                ->where('workspace_id', $workspaceId)
                ->where('project_id', null)
                ->groupEnd();
        }
        $builder->groupEnd();

        if ($category !== 'all' && !empty($category)) {
            $builder->where('category', strtolower($category));
        }

        if (!empty($search)) {
            $builder->groupStart()
                ->like('name', $search)
                ->orLike('description', $search)
                ->orLike('category', $search)
                ->groupEnd();
        }

        return $builder->orderBy('category', 'ASC')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get all skills for a specific project:
     * Combines global skills (optionally matching project services) + custom skills for that project.
     */
    public function getProjectSkills(int $projectId, array $services = [])
    {
        // 1. Fetch custom skills for this project
        $customSkills = $this->where('project_id', $projectId)
            ->orderBy('id', 'DESC')
            ->findAll();

        // 2. Fetch global skills
        $globalSkills = $this->where('is_global', 1)
            ->where('project_id', null)
            ->orderBy('category', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();

        return [
            'custom' => $customSkills,
            'global' => $globalSkills,
        ];
    }
}
