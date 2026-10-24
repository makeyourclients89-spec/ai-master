<?php

namespace App\Models;

use CodeIgniter\Model;

class GscConnectionModel extends Model
{
    protected $table            = 'gsc_connections';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'workspace_id',
        'user_id',
        'google_email',
        'account_name',
        'avatar_url',
        'access_token',
        'refresh_token',
        'token_expires_at',
        'scopes',
        'status',
        'last_sync',
        'created_at',
        'updated_at'
    ];
}
