<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['domain' => 'store.dwy.com','namespace'=>'Admin'], function ($router) {
    $router->match(['get','post'],'/login','LoginController@login');

    $router->get('logout','LoginController@logout');
    $router->group(['middleware' => 'auth:admin'],function($router){
        $router->get('/index', 'IndexController@index');

        #RBAC
        $router->resource('admins', 'AdminController');//管理员管理
        $router->resource('role', 'RoleController');//角色管理
        $router->resource('permission', 'PermissionController');//权限管理
    });
});

