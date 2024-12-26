<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Admin\AdminModel;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{

    public function adminLoginPage()
    {
        $session = \Config\Services::session();

        if ($session->get("isLoggedIn")) {
            return $this->response->redirect(url_to('admin_dashboard'));
        }

        $data['pageTitle'] = "Login Required";

        return view("auth/admin_login", $data);
    }

    public function doLoginAdmin()
    {

        $adminModel = new AdminModel();
        $session = \Config\Services::session();


        if ($this->request->getPost()) {
            $email = $this->request->getPost("email");
            $password = $this->request->getPost("password");

            $result = $adminModel->where("email", $email)->first();

            if ($result) {
                if (password_verify($password, $result['password'])) {

                    $session->set([
                        'admin_user_id' => $result['id'],
                        'isLoggedIn' => true
                    ]);

                    update_last_login_admin($result['id']);
                    log_activity("ADMIN LOGIN", "USER LOGGED IN:" . $result["id"]);

                    $redirectURL = session()->getFlashdata('pre_loging_request') ?? url_to('admin_dashboard');

                    return $this->response->redirect($redirectURL);
                } else {
                    $session->setFlashdata('error', 'Incorrect Password');
                    return $this->response->redirect(url_to('admin_login'));
                }

            } else {
                $session->setFlashdata('error', 'User Not Found');
                return $this->response->redirect(url_to('admin_login'));
            }
        }
    }

    function hash(string $password)
    {
        return hash_password($password);
    }
}
