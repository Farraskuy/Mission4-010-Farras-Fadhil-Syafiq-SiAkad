<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// $routes->get('/hello-world', 'HelloWorld::index');
// $routes->get('/html-table', 'HelloWorld::html_table');

$routes->group('', ['filter' => 'guest'], function () use ($routes) {
    $routes->get("/login", "AuthController::login");
    $routes->post("/login", "AuthController::Authlogin");
    // $routes->get("/register", "AuthController::register");
    // $routes->post("/register", "AuthController::AuthRegister");
});

$routes->group('', ['filter' => 'auth'], function () use ($routes) {
    $routes->post("/logout", "AuthController::logout");
    
    $routes->get('/', 'DashboardController::index');


    $routes->group('/mahasiswa', ['filter' => 'mahasiswa'], function () use ($routes) {
        $routes->get("/", "Mahasiswa::index");
        $routes->get("tambah", "Mahasiswa::tambah");
        $routes->post("tambah", "Mahasiswa::store");
        $routes->get("detail/(:num)", "Mahasiswa::detail/$1");
        $routes->get("edit/(:num)", "Mahasiswa::edit/$1");
        $routes->put("edit/(:num)", "Mahasiswa::update/$1");
        $routes->get("delete/(:num)", "Mahasiswa::delete/$1");
        $routes->delete("delete/(:num)", "Mahasiswa::destroy/$1");
    });
});
