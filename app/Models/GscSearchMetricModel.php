<?php

namespace App\Models;

use CodeIgniter\Model;

class GscSearchMetricModel extends Model
{
    protected $table            = 'gsc_search_metrics';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'project_id',
        'property_id',
        'date',
        'dimension',
        'dimension_value',
        'clicks',
        'impressions',
        'ctr',
        'position',
        'synced_at'
    ];
}
