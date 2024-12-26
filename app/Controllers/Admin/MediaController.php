<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MediaController extends BaseController
{
    public function index()
    {

        $data["page"] = "media/index";
        $data["pageTitle"] = "Media";
        $data["pageId"] = "media";


        return view(ADMIN_VIEW, $data);

    }
}
