<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        //

        $data["page"] = "dashboard/index";
        $data["pageTitle"] = "Dashboard";
        $data["pageId"] = "dashboard";
        

        return view(ADMIN_VIEW, $data);
    }
}
