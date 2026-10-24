<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectTaskModel extends Model
{
    protected $table            = 'project_tasks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'project_id', 'title', 'description', 'expected_output',
        'category', 'frequency', 'priority', 'status',
        'is_verified', 'verified_by', 'verified_at', 'recurring_schedule',
        'assigned_user', 'assigned_agent', 'created_at', 'updated_at'
    ];
    protected $useTimestamps    = true;
}
