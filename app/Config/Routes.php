<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\BaseController;

/**
 * @var RouteCollection $routes
 */


$routes->group("admin", ['namespace' => 'App\Controllers\Admin', 'filter' => 'adminauth'], function (RouteCollection $routes) {
    $routes->get('/', 'DashboardController::index', ['as' => 'admin_dashboard']);

    $routes->group('category', function ($routes) {
        $routes->get('list', 'CategoriesController::index', ['as' => 'categories.list']);
        $routes->post('add', 'CategoriesController::addCategory', ['as' => 'categories.add']);
        $routes->post('edit/(:any)', 'CategoriesController::editCategory/$1', ['as' => 'categories.edit']);

        $routes->group('ajax', static function ($routes) {
            $routes->post('check_slug', 'CategoriesController::checkSlugAPI', ['as' => 'ajax.category.slug']);
            $routes->post('fetch_data_table', 'CategoriesController::apiDataTable', ['as' => 'ajax.category.list']);
            $routes->post('fetch_editform', 'CategoriesController::editAPI', ['as' => 'ajax.editform']);
            $routes->post('delete_category', 'CategoriesController::deleteAPI', ['as' => 'ajax.delete.cat']);
        });
    });

    $routes->group('media', function ($routes) {
        $routes->get('/', 'MediaController::index', ['as' => 'media.home']);
    });
});

$routes->group("auth", ["namespace" => "App\Controllers"], function (RouteCollection $routes) {

    $routes->get("admin", "AuthController::adminLoginPage", ['as' => 'admin_login']);
    $routes->post('admin/processLogin', 'AuthController::doLoginAdmin', ['as' => 'admin_processLogin']);

    // $routes->get('admin/hash/(:any)','AuthController::hash/$1', ['as'=> 'admin_processLogin_hash']);
});
