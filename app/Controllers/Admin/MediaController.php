<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\AdminModel;
use CodeIgniter\HTTP\ResponseInterface;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class MediaController extends BaseController
{

    protected $imageManager;
    protected $uploadDir;

    protected $adminModel;
    protected $username;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
        $this->adminModel = new AdminModel();
        $this->username = $this->adminModel->where('id', getCurrentAdmin())->first()['name'];

        $this->uploadDir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $this->username . DIRECTORY_SEPARATOR;
    }

    public function index()
    {

        $data["page"] = "media/index";
        $data["pageTitle"] = "Media";
        $data["pageId"] = "media";


        return view(ADMIN_VIEW, $data);

    }

    public function upload()
    {
        $response = [];

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }

        // var_dump($_FILES);
        // exit;

        // Check if file was uploaded
        if ($this->request->getFile('image')->isValid()) {
            $file = $this->request->getFile('image');
            $fileName = $file->getName();
            $filePath = $this->uploadDir . $fileName;

            // Move the file to the uploads directory
            $file->move($this->uploadDir);

            // Resize and compress the image using Intervention Image
            $image = $this->imageManager->read($filePath);
            // $image->resize(800, 600);
            $image->save($filePath, 75);

            // Return the file path or URL
            $response['file'] = base_url('uploads/' . $this->username . '/' . $fileName);
            $response['unlink_path'] = $filePath;
            $response['message'] = 'File uploaded successfully!';
        } else {
            $response['error'] = 'No file uploaded or file error.';
        }

        // Return the response as JSON
        return $this->response->setJSON($response);
    }


    public function revert()
    {
        $response = [];

        // File path from FilePond
        $var = json_decode($this->request->getBody());
        $filePath = $var->unlink_path;

        $response['file'] = $filePath;
        // Delete the file if it exists
        if (file_exists($filePath)) {
            unlink($filePath);
            $response['message'] = 'File removed';
        } else {
            $response['error'] = 'File not found';
        }

        return $this->response->setJSON($response);
    }
}
