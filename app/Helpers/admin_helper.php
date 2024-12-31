<?php

use App\Models\Admin\AdminModel;
use App\Models\CategoryModel;
use App\Models\SettingModel;
use CodeIgniter\Config\Services;

/**
 * ADMIN HELPER
 * @author Ashok kumar
 */


if (!function_exists('admin_url')) {
    /**
     * @name admin_url
     * @author Ashok kumar
     * Returns the Admin URL use this As an Helper!
     * @param string $path
     * @return string
     */
    function admin_url(string $path = '')
    {

        $admin_base = base_url() . ADMIN_URL . '/';

        if ($path && !empty($path)) {
            $return_url = $admin_base . $path;
        } else {
            $return_url = $admin_base;
        }

        return $return_url;
    }
}

/**
 * Helper function to get a setting by name.
 *
 * @param string $setting_name The name of the setting.
 * @return string|null The setting value or null if not found.
 */
if (!function_exists('get_setting')) {
    function get_setting($setting_name)
    {
        // Initialize the SettingModel
        $settingModel = new SettingModel();

        // Get the setting from the database
        $setting = $settingModel->getSetting($setting_name);

        // Return the setting value or null if not found
        return $setting ? $setting['setting_value'] : null;
    }
}

if (!function_exists('setFlashData')) {

    /**
     * THIS FUNCTION IS USED TO SET THE FLASHDATA ALOGN WITH THE MESSAGE TYPE 
     * THIS WILL HELPS TO SHOW THE ALERT ON THE SCREEN
     * @param string $type ex: error OR success
     * @param string $message ex: Insert or update successfull
     * @return void
     */
    function setFlashData(string $type = '', string $message)
    {
        $session = \Config\Services::session();

        $session->setFlashdata('type', $type);
        $session->setFlashdata('message', $message);
    }
}


if (!function_exists('isAdminLoggedIn')) {
    /**
     * @name isAdminLoggedIn
     * @author Ashok kumar
     * Used to check the user logged in or not
     * @return bool
     */
    function isAdminLoggedIn()
    {

        $session = \Config\Services::session();
        if ($session->has('admin_user_id')) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('getCurrentAdmin')) {
    /**
     * @name getCurrentAdmin
     * @author Ashok kumar
     * Used to get the current admin
     * @return mixed
     */
    function getCurrentAdmin()
    {
        $session = \Config\Services::session();

        if ($session->has('admin_user_id') && $session->get('admin_user_id')) {
            return $session->get('admin_user_id');
        }

        return null;
    }
}

if (!function_exists('getAdminNameById')) {
    /**
     * @name getAdminNameById
     * @author Ashok kumar
     * Used to get the current admin name
     * @return mixed
     */
    function getAdminNameById($id)
    {
        $adminModel = new AdminModel();
        $result = $adminModel->where('id', $id)->first();

        if ($result) {
            return $result['name'] ?? '--';
        } else {
            return "--";
        }
    }
}

if (!function_exists('update_last_login_admin')) {
    function update_last_login_admin($user_id)
    {
        // Get the instance of CodeIgniter
        $db = \Config\Database::connect();

        // Prepare the data to update
        $data = [
            'last_login' => date('Y-m-d H:i:s'), // Current timestamp
            'last_login_ip' => \Config\Services::request()->getIPAddress() // Get user's IP address
        ];

        $builder = $db->table('admins');

        if ($builder->where('id', $user_id)->update($data)) {
            return true;
        } else {
            log_message('error', 'Failed To Update The Login Details' . $user_id . '');
        }
    }
}


if (!function_exists('b_assets')) {
    /**
     * Generate the URL for assets in the b_assets folder.
     *@author Ashok kumar <email>
     * @param string $path The path to the asset relative to the b_assets folder.
     * @return string The full URL to the asset.
     */
    function b_assets($path)
    {
        return base_url('b_assets/' . ltrim($path, '/'));
    }
}


if (!function_exists('hash_password')) {
    /**
     * Hashes a plain password.
     *
     * @param string $password The plain password to hash.
     * @return string The hashed password.
     */
    function hash_password(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}

if (!function_exists('verify_password')) {
    /**
     * Verifies a plain password against a hashed password.
     *
     * @param string $password The plain password.
     * @param string $hashedPassword The hashed password.
     * @return bool True if the password matches, false otherwise.
     */
    function verify_password(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }
}


if (!function_exists('log_activity')) {
    function log_activity($title, $log)
    {
        $db = \Config\Database::connect();
        $log_text = $log ?? 'EMPTY LOG';
        $done_by = getCurrentAdmin();

        if ($done_by !== null) {
            $query = 'INSERT INTO activity_log(title, log_text, url, done_by, created_at) VALUES(?, ?, ?, ?, ?)';
            $db->query(
                $query,
                array(
                    $title ?? "ADMIN",
                    $log_text,
                    current_url(),
                    $done_by,
                    date("Y-m-d H:i:s")
                )
            );
        } else {
            log_message('error', 'User ID not found in session');
        }
    }
}



/**
 * Functions to encode uri => Made for id encoding for security purposes
 */

if (!function_exists('safe_b64decode')) {
    function safe_b64decode($string = '')
    {
        $data = str_replace(['-', '_'], ['+', '/'], $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
}

if (!function_exists('safe_b64encode')) {
    function safe_b64encode($string = '')
    {
        $data = base64_encode($string);
        $data = str_replace(['+', '/', '='], ['-', '_', ''], $data);
        return $data;
    }
}


if (!function_exists('uencode')) {
    function uencode($value = false)
    {
        if (!$value)
            return false;
        $iv_size = openssl_cipher_iv_length('aes-256-cbc');
        $iv = openssl_random_pseudo_bytes($iv_size);
        $crypttext = openssl_encrypt($value, 'aes-256-cbc', secret_key(), OPENSSL_RAW_DATA, $iv);
        return safe_b64encode($iv . $crypttext);
    }
}
if (!function_exists('udecode')) {
    function udecode($value = false)
    {
        if (!$value)
            return false;
        $crypttext = safe_b64decode($value);
        $iv_size = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($crypttext, 0, $iv_size);
        $crypttext = substr($crypttext, $iv_size);
        if (!$crypttext)
            return false;
        $decrypttext = openssl_decrypt($crypttext, 'aes-256-cbc', secret_key(), OPENSSL_RAW_DATA, $iv);
        return rtrim($decrypttext);
    }
}

if (!function_exists('secret_key')) {
    function secret_key($string = '')
    {
        $data = 'Ashokkumar';
        $data = str_replace(['+', '/', '='], ['-', '_', ''], $data);
        return $data;
    }
}

// CATEGORY HELPER FUNCTIONS

if (!function_exists('renderCategoryOptions')) {
    function renderCategoryOptions($selected = '')
    {
        $categoryModel = new CategoryModel();
        $data = $categoryModel->select('name, id')->findAll();
        ob_start();
        $response = "<option value=''>Select Category</option>";
        foreach ($data as $category) {
            $categoryId = $category['id'];
            $categoryName = $category['name'];

            $isSelected = $categoryId == $selected ? 'selected' : '';

            // echo "<option value=\"$categoryId\" $isSelected>$categoryName</option>";
            $response .= "<option value=\"$categoryId\" $isSelected>$categoryName</option>";
        }
        echo $response;
        return ob_get_clean();
    }
}

if (!function_exists('getCategoryNameById')) {
    function getCategoryNameById($categoryId)
    {
        $categoryModel = new CategoryModel();
        $data = $categoryModel->select('category_name')->where('category_id', $categoryId)->first();

        if ($data) {
            return $data['category_name'];
        } else {
            return '--';
        }
    }
}

if (!function_exists(function: 'makeSlug')) {
    /**
     * This function is used to convert an string into an url friendly slug!
     * @param mixed $string
     * @return string
     */
    function makeSlug($string)
    {
        // Convert the string to lowercase
        $string = strtolower($string);

        // Remove special characters
        $string = preg_replace('/[^a-z0-9\s-]/', '', $string);

        // Replace spaces and multiple hyphens with a single hyphen
        $string = preg_replace('/[\s-]+/', '-', $string);

        // Trim hyphens from the beginning and end
        $string = trim($string, '-');

        return $string;
    }
}
