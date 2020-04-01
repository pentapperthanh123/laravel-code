<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{   
    // yêu cầu người dùng đã xác thực
    public function __construct()
    {
        $this->middleware('auth');
    }
}
