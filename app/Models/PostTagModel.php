<?php

namespace App\Models;

use CodeIgniter\Model;

class PostTagModel extends Model
{
    protected $table = 'post_tags';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['post_id', 'tag_id'];
}
