<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    public function index()
    {
        $model = new ProductModel();
        return view('home', ['products' => $model->findAll()]);
    }
}
