<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// $routes->get('/hello-world', 'HelloWorld::index');
// $routes->get('/html-table', 'HelloWorld::html_table');

$routes->group('', ['filter' => 'auth:guest'], function () use ($routes) {
    $routes->get("/login", "AuthController::login");
    $routes->post("/login", "AuthController::Authlogin");
    // $routes->get("/register", "AuthController::register");
    // $routes->post("/register", "AuthController::AuthRegister");
});

$routes->group('', ['filter' => 'auth:login'], function () use ($routes) {
    $routes->post("/logout", "AuthController::logout");

    $routes->get('/', 'DashboardController::index');

    $routes->group('/student', ['filter' => 'auth:admin'], function () use ($routes) {
        $routes->get("/", "StudentController::index");
        $routes->get("tambah", "StudentController::tambah");
        $routes->post("tambah", "StudentController::store");
        $routes->get("detail/(:num)", "StudentController::detail/$1");
        $routes->get("update/password/(:num)", "StudentController::edit_password/$1");
        $routes->put("update/password/(:num)", "StudentController::update_password/$1");
        $routes->get("update/(:num)", "StudentController::edit/$1");
        $routes->put("update/(:num)", "StudentController::update/$1");
        $routes->delete("delete/(:num)", "StudentController::destroy/$1");
    });

    $routes->get("/course", "CourseController::index");
    $routes->post("/course/enroll/(:num)", "CourseController::enroll/$1");
    $routes->post("/course/unenroll/(:num)", "CourseController::unenroll/$1");

    $routes->group('/course', ['filter' => 'auth:admin'], function () use ($routes) {
        $routes->get("tambah", "CourseController::tambah");
        $routes->post("tambah", "CourseController::store");
        $routes->get("detail/(:num)", "CourseController::detail/$1");
        $routes->get("update/(:num)", "CourseController::edit/$1");
        $routes->put("update/(:num)", "CourseController::update/$1");
        $routes->delete("delete/(:num)", "CourseController::destroy/$1");
    });
});
