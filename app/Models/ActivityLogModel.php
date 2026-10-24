<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table            = 'activity_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'workspace_id', 'user_name', 'action', 'target', 'created_at'
    ];

    public static function log(int $workspaceId, string $userName, string $action, ?string $target = null)
    {
        $db = \Config\Database::connect();
        $db->table('activity_logs')->insert([
            'workspace_id' => $workspaceId,
            'user_name'    => $userName,
            'action'       => $action,
            'target'       => $target,
            'created_at'   => date('Y-m-d H:i:s'),
        ]);
    }
}
