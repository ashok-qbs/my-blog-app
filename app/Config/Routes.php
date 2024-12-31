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

    $routes->group('post', function ($routes) {
        $routes->get('list', 'PostController::index', ['as' => 'posts.list']);
        $routes->get('add_page', 'PostController::addPage', ['as' => 'posts.add.page']);

        $routes->group('ajax', static function ($routes) {
            $routes->post('check_slug', 'PostController::checkSlugAPI', ['as' => 'ajax.post.slug']);
            $routes->post('fetch_data_table', 'PostController::apiDataTable', ['as' => 'ajax.post.list']);
            $routes->post('delete', 'PostController::deleteAPI', ['as' => 'ajax.delete.post']);
        });
    });

    $routes->group('tags', function ($routes) {

        $routes->group('ajax', static function ($routes) {
            //

            $routes->match(['get', 'post'],'fetch_tags', 'TagsController::fetchTags', ['as' => 'api.fetch_tags']);
            $routes->post('add_tags', 'TagsController::addTag', ['as' => 'api.add_tags']);
        });
    });

    $routes->group('media', function ($routes) {
        $routes->get('/', 'MediaController::index', ['as' => 'media.home']);

        $routes->group('api', static function ($routes) {
            $routes->post('upload', 'MediaController::upload', ['as' => 'media.post.upload']);
            $routes->delete('revert', 'MediaController::revert', ['as' => 'media.post.revert']);

        });
    });
});

$routes->group("auth", ["namespace" => "App\Controllers"], function (RouteCollection $routes) {

    $routes->get("admin", "AuthController::adminLoginPage", ['as' => 'admin_login']);
    $routes->post('admin/processLogin', 'AuthController::doLoginAdmin', ['as' => 'admin_processLogin']);

    // $routes->get('admin/hash/(:any)','AuthController::hash/$1', ['as'=> 'admin_processLogin_hash']);
});
