<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class AccountController extends Controller
{

    public $model;
    public function __construct()
    {
        $this->model = new Account();
    }
    //
    public function register(Request $request)
    {
        return $this->model->register($request);
    }

    public function authenticate(Request $request)
    {
        return $this->model->authenticate($request);
    }

    public function logOut()
    {
        return $this->model->logOut();
    }
}
