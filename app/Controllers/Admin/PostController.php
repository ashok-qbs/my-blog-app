<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostModel;
use CodeIgniter\HTTP\ResponseInterface;

class PostController extends BaseController
{

    protected $postsModel;
    public function __construct()
    {
        $this->postsModel = new PostModel();
    }
    public function index()
    {
        $data["page"] = "post/index";
        $data["pageTitle"] = "Posts";
        $data["pageId"] = "post";


        return view(ADMIN_VIEW, $data);
    }

    public function addPage()
    {
        $data["page"] = "post/add";
        $data["pageTitle"] = "Add New Post";
        $data["pageId"] = "post";


        return view(ADMIN_VIEW, $data);
    }

    public function addNewPost()
    {
        if ($this->request->getPost()) {

            // var_dump($this->request->getPost('tags'));
            // exit;

            $postData['title'] = $this->request->getPost('title');
            $postData['slug'] = $this->request->getPost('post_slug');
            $postData['category_id'] = $this->request->getPost('category');
            $postData['content'] = $this->request->getPost('content');
            $postData['summary'] = $this->request->getPost('summary');
            $postData['status'] = $this->request->getPost('status');
            $postData['meta_description'] = $this->request->getPost('meta_description');
            $postData['meta_keywords'] = $this->request->getPost('meta_keywords');

            $postData['created_by'] = getCurrentAdmin();

            if ($this->postsModel->save($postData)) {

                $postID = $this->postsModel->insertID();
                $tags = explode(",", $this->request->getPost('tags'));

                $tagData = [];

                foreach ($tags as $tag) {
                    $tag = trim($tag);
                    $tagData[] = [
                        'post_id' => $postID,
                        'tag' => $tag
                    ];
                }
                $this->postsModel->insertTag($tagData);
                setFlashData('success', 'Post Added Successfully');
            } else {
                setFlashData('error', 'Failed to Add Post');
            }

        } else {
            setFlashData('error', 'Invalid Request');
        }

        return $this->response->redirect(url_to('posts.list'));
    }

    public function editPage($ref)
    {
        $ref = udecode($ref);

        $data["page"] = "post/edit";
        $data["pageTitle"] = "Edit Post";
        $data["pageId"] = "post";


        return view(ADMIN_VIEW, $data);
    }


    public function checkSlugAPI()
    {
        $response = [];

        $requestSlug = makeSlug($this->request->getPost('slug'));

        if (empty($requestSlug)) {
            $response['status'] = FALSE;
            $response['message'] = "Invalid Slug";
            $response['final_slug'] = $requestSlug;
            return $this->response->setJSON($response);
        }

        if ($this->request->getPost()) {


            $result = $this->postsModel->where('slug', $requestSlug)->first();

            if ($result) {
                $response['status'] = FALSE;
                $response['message'] = "Slug Already Exits";
            } else {
                $response['status'] = TRUE;
                $response['message'] = "Slug Available!";
            }
        } else {
            $response['status'] = FALSE;
            $response['message'] = "Invalid Request";
        }

        $response['final_slug'] = $requestSlug;

        return $this->response->setJSON($response);
    }



}
