<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class HelloWorld extends BaseController
{
    public function index()
    {
        echo "Hello world";
    }

    public function html_table() {
        return view("html_table");
    }
}
