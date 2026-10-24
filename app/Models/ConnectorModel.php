<?php

namespace App\Models;

use CodeIgniter\Model;

class ConnectorModel extends Model
{
    protected $table            = 'connectors';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'project_id', 'type', 'name', 'config_json', 'status',
        'last_sync', 'created_at'
    ];
}
