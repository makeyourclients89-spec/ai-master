<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectWebsiteModel extends Model
{
    protected $table            = 'project_websites';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'project_id',
        'label',
        'url',
        'is_primary',
        'notes',
        'scan_data',
        'scanned_at',
        'cms_platform',
        'seo_score',
        'status_code',
        'response_time_ms',
        'created_at'
    ];
}
