<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectFileModel extends Model
{
    protected $table            = 'project_files';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'project_id',
        'user_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'category',
        'notes',
        'extracted_text',
        'ai_summary',
        'archive_contents',
        'is_ingested',
        'ingested_at',
        'created_at',
        'updated_at'
    ];
}
