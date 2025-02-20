<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PaymentController extends BaseController
{
    public function success()
    {
        return view('success');
    }

    public function error()
    {
        return view('error');
    }
}
