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

        helper(['image']);

        $this->uploadDir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $this->username . DIRECTORY_SEPARATOR;
    }

    public function index()
    {

        $data["page"] = "media/index";
        $data["pageTitle"] = "Media";
        $data["pageId"] = "media";


        return view(ADMIN_VIEW, $data);
    }

    public function upload_temp()
    {
        $response = [];

        if (!is_dir($this->uploadDir . 'temp' . DIRECTORY_SEPARATOR)) {
            mkdir($this->uploadDir . 'temp' . DIRECTORY_SEPARATOR, 0755, true);
        }

        if (session()->has('temp_file')) {
            $file = session()->getFlashdata('temp_file');

            if (file_exists($file)) {
                @unlink($file);
            }
        }

        // Check if file was uploaded
        if ($this->request->getFile('file')->isValid()) {
            $file = $this->request->getFile('file');
            $fileName = $file->getName();
            $filePath = $this->uploadDir . 'temp' . DIRECTORY_SEPARATOR;

            // Move the file to the temporary uploads directory
            $file->move($filePath);

            // Return the file path or URL
            $response['file_url'] = base_url('uploads/' . $this->username . '/temp/' . $fileName);
            $response['unlink_path'] = $filePath;

            session()->setFlashdata('temp_file', $filePath);

            $response['message'] = 'File uploaded successfully!';
        } else {
            $response['error'] = 'No file uploaded or file error.';
        }

        // Return the response as JSON
        return $this->response->setJSON($response);
    }

    public function upload()
    {
        $response = [];

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }

        if (session()->has('temp_file')) {
            $file = session()->getFlashdata('temp_file');

            if (file_exists($file)) {
                @unlink($file);
            }
        }

        $logger = \Config\Services::logger();

        $logger->error('FILE POST', (array) $this->request->getFile('file'));
        $logger->error('FILE POST', (array) $this->request->getPost());
        $logger->error('FILE POST', (array) $this->request->getBody());

        // Check if file was uploaded
        if ($this->request->getPost()) {

            $base64 = $this->request->getPost('file');
            $fileName = $this->generateRandomString(10);

            $filePath = decode_base64_image($base64, $this->uploadDir, $fileName);
            $fileExtension = get_base64_image_file_ext($base64)[0];

            // Resize and compress the image using Intervention Image
            $image = $this->imageManager->read($filePath);
            $image->save($filePath, 75);

            // Return the file path or URL
            $response['file_url'] = base_url('uploads/' . $this->username . '/' . $fileName . '.' . $fileExtension);
            $response['unlink_path'] = $filePath;
            $response['message'] = 'File uploaded successfully!';
            $response['status'] = TRUE;
        } else {
            $response['error'] = 'No file uploaded or file error.';
            $response['status'] = FALSE;
        }

        // Return the response as JSON
        return $this->response->setJSON($response);
    }


    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
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
