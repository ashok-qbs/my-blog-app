<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\PostTagModel;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id',
        'title',
        'slug',
        'content',
        'summary',
        'image',
        'created_by',
        'category_id',
        'status',
        'meta_description',
        'meta_keywords'
    ];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';


    public function insertTag($batchData)
    {
        $post_tag_model = new PostTagModel();

        return $post_tag_model->insertBatch($batchData);
    }
}
