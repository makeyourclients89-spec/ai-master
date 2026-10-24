<?php

namespace App\Models;

use CodeIgniter\Model;

class AiAgentModel extends Model
{
    protected $table            = 'ai_agents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'workspace_id', 'provider', 'name', 'model', 'api_key',
        'status', 'system_prompt', 'total_runs', 'created_at'
    ];
}
