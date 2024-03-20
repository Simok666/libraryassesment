<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    // create laravel index function
    public function index(Request $request, $view = "AuthLogin") {
        return view($view);
    }
}
