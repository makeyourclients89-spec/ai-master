<?php

namespace App\Models;

use CodeIgniter\Model;

class GscProjectMappingModel extends Model
{
    protected $table            = 'gsc_project_mappings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'project_id',
        'property_id',
        'is_active',
        'synced_at',
        'created_at'
    ];
}
