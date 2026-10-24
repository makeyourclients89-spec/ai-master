<?php

namespace App\Models;

use CodeIgniter\Model;

class GscPropertyModel extends Model
{
    protected $table            = 'gsc_properties';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'connection_id',
        'site_url',
        'permission_level',
        'is_domain_property',
        'created_at'
    ];
}
