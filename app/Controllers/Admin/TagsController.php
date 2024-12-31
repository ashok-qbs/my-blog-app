<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TagsModel;
use CodeIgniter\HTTP\ResponseInterface;

class TagsController extends BaseController
{
    public function index()
    {
        //
    }


    public function fetchTags()
    {
        $tagModel = new TagsModel();

        $query = $this->request->getVar('q') ?? '';

        $tags = $tagModel->like('name', $query)
            ->select('id, name')
            ->findAll(10);

        return $this->response->setJSON(['data' => $tags]);
    }

    public function addTag()
    {
        $tagName = $this->request->getVar('name');

        // $tagName = $data['name'];

        $tagModel = new TagsModel();

        // Check if the tag already exists
        $existingTag = $tagModel->where('name', $tagName)->first();

        if ($existingTag) {
            return $this->response->setJSON(['status' => 'exists', 'id' => $existingTag['id']]);
        }

        // Insert the new tag
        $tagId = $tagModel->insert([
            'name' => $tagName,
            'slug' => makeSlug($tagName),
            'added_by' => getCurrentAdmin()
        ]);

        return $this->response->setJSON(['status' => 'success', 'id' => $tagId]);
    }
}
