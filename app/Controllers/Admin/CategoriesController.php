<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use CodeIgniter\HTTP\ResponseInterface;

class CategoriesController extends BaseController
{

    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data["page"] = "categories/index";
        $data["pageTitle"] = "Categories";
        $data["pageId"] = "category";


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
        $totalRecords = $this->categoryModel->countAllResults();

        // Query for filtered records
        $query = $this->categoryModel;

        if (!empty($search)) {
            $query = $query->like('name', $search)
                ->orLike('description', $search);
        }

        $totalFiltered = $query->countAllResults(false);

        // Fetch paginated and ordered data
        $data = $query->orderBy($columnOrder, $orderDir)
            ->findAll($length, $start);

        // Format data for DataTables
        $response = [];
        foreach ($data as $rec) {
            $editButton = '<button class="btn btn-icon btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editCategory" data-ref="' . uencode($rec['id']) . '">Edit</button>';
            $deleteButton = '<button class="btn btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-ref="' . uencode($rec['id']) . '" data-url="' . url_to('ajax.delete.cat') . '">Delete</button>';

            $actions = "<div class='d-flex align-items-center justify-space-between list-user-action'>"
                . $editButton . $deleteButton . "</div>";

            $response[] = [
                'name' => $rec['name'],
                'created_by' => 'Admin',
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

    public function addCategory()
    {
        if ($this->request->getPost()) {
            $postData['name'] = $this->request->getPost('category_name');
            $postData['slug'] = $this->request->getPost('category_slug');
            $postData['description'] = $this->request->getPost('category_desc');
            $postData['meta_title'] = $this->request->getPost('category_name');
            $postData['meta_description'] = $this->request->getPost('category_meta_desc');
            $postData['meta_keywords'] = $this->request->getPost('category_meta_keyword');

            if ($this->checkValidSlug($postData['slug'])) {
                if ($this->categoryModel->save($postData)) {
                    setFlashData('success', 'New Category Added Successfully');
                } else {
                    setFlashData('error', 'There is an Issue While Saving!');
                }
            } else {
                setFlashData('error', 'Not An Valid Slug!');
            }
        } else {
            setFlashData('error', 'Invalid Request');
        }

        return $this->response->redirect(url_to('categories.list'));
    }

    public function editCategory($id)
    {
        $id = udecode($id);

        if (!$id) {
            setFlashData('error', 'Invalid Response From Server');
            return $this->response->redirect(url_to('categories.list'));
        }

        if ($this->request->getPost()) {
            $postData['name'] = $this->request->getPost('e_category_name');
            $postData['slug'] = $this->request->getPost('e_category_slug');
            $postData['description'] = $this->request->getPost('e_category_desc');
            $postData['meta_title'] = $this->request->getPost('e_category_name');
            $postData['meta_description'] = $this->request->getPost('e_category_meta_desc');
            $postData['meta_keywords'] = $this->request->getPost('e_category_meta_keyword');

            if ($this->checkValidSlug($postData['slug'], $id)) {

                if ($this->categoryModel->update($id, $postData)) {
                    setFlashData('success', 'Category Updated Successfully');
                } else {
                    setFlashData('error', 'There is an Issue While Saving!');
                }
            } else {
                setFlashData('error', 'Not An Valid Slug!');
            }
        } else {
            setFlashData('error', 'Invalid Request');
        }

        return $this->response->redirect(url_to('categories.list'));
    }

    public function editAPI()
    {
        $ref = udecode($this->request->getVar('ref'));

        $data["data"] = $this->categoryModel->where('id', $ref)->first();

        return view("admin/categories/editResponse", $data);
    }

    public function deleteAPI()
    {
        $ref = udecode($this->request->getVar('ref'));

        if (!$ref) {
            return $this->response->setStatusCode(500);
        }

        if ($this->request->getPost()) {
            if ($this->categoryModel->delete($ref)) {
                setFlashData('success', 'Category Deleted Successfully!');
            } else {
                setFlashData('error', 'Internal Error While Performing Delete!');
            }
            return $this->response->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(400);
        }
    }


    /**
     * This Private Function is used to check the slug before inserting it into the table!
     * @param string $slug
     * @return boolean
     */
    private function checkValidSlug($slug, $id = '')
    {

        if ($id != '') {
            $result = $this->categoryModel->where('slug', $slug)->where('id', $id)->first();

            if ($result) {
                return true;
            } else {
                // WE CAN ALSO WRITE LIKE THIS
                // DON'T GET CONFUSED
                return !$this->categoryModel->where('slug', $slug)->first();
            }

        } else {
            $result = $this->categoryModel->where('slug', $slug)->first();

            if (!$result) {
                return true;
            } else {
                return false;
            }
        }
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


            $result = $this->categoryModel->where('slug', $requestSlug)->first();

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
