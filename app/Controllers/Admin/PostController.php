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
