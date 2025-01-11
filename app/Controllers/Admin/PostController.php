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

    public function apiDataTable(): mixed
    {
        $request = $this->request;

        $draw = $request->getVar('draw');
        $start = $request->getVar('start');
        $length = $request->getVar('length');
        $search = $request->getVar('search')['value'];
        $order = $request->getVar('order');
        $columns = $request->getVar('columns');

        // Fix ordering
        $columnIndex = $order[0]['column']; // Column index from DataTable
        $columnOrder = $columns[$columnIndex]['data']; // Column name
        $orderDir = $order[0]['dir']; // ASC or DESC

        // Total records count
        $totalRecords = $this->postsModel->countAllResults();

        // Query for filtered records
        $query = $this->postsModel;

        if (!empty($search)) {
            $query = $query->like('title', $search)
                ->orLike('meta_description', $search);
        }

        $totalFiltered = $query->countAllResults(false);

        // Fetch paginated and ordered data
        $data = $query->orderBy($columnOrder, $orderDir)
            ->findAll($length, $start);

        // Format data for DataTables
        $response = [];
        foreach ($data as $rec) {
            $editButton = '<a class="btn btn-icon btn-primary me-2" href="'.url_to('posts.edit.page', uencode($rec['id'])).'" data-ref="' . uencode($rec['id']) . '">Edit</a>';
            $deleteButton = '<button class="btn btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-ref="' . uencode($rec['id']) . '" data-url="' . url_to('ajax.delete.post') . '">Delete</button>';

            $actions = "<div class='d-flex align-items-center justify-space-between list-user-action'>"
                . $editButton . $deleteButton . "</div>";

            $response[] = [
                'title' => $rec['title'],
                'category' => getCategoryNameById($rec['category_id']),
                'created_by' => getAdminNameById(getCurrentAdmin()),
                'created_at' => $rec['created_at'],
                'actions' => $actions,
            ];
        }

        return $this->response->setJSON([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $response
        ]);
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

            $postData['title'] = $this->request->getPost('title');
            $postData['slug'] = $this->request->getPost('post_slug');
            $postData['category_id'] = $this->request->getPost('category');
            $postData['content'] = $this->request->getPost('content');
            $postData['summary'] = $this->request->getPost('summary');
            $postData['status'] = $this->request->getPost('status');
            $postData['meta_description'] = $this->request->getPost('meta_description');
            $postData['meta_keywords'] = $this->request->getPost('meta_keywords');

            $postData['image'] = $this->request->getPost('post-image');

            $postData['created_by'] = getCurrentAdmin();

            if ($this->postsModel->save($postData)) {

                $postID = $this->postsModel->insertID();
                $tags = explode(",", $this->request->getPost('tags'));


                $tagData = [];

                foreach ($tags as $tag) {
                    $tag = trim($tag);
                    $tagData[] = [
                        'post_id' => $postID,
                        'tag_id' => $tag
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

    public function deleteAPI()
    {
        $ref = udecode($this->request->getVar('ref'));

        if (!$ref) {
            return $this->response->setStatusCode(500);
        }

        if ($this->request->getPost()) {
            if ($this->postsModel->delete($ref)) {
                setFlashData('success', 'Post Deleted Successfully!');
            } else {
                setFlashData('error', 'Internal Error While Performing Delete!');
            }
            return $this->response->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(400);
        }
    }
}
