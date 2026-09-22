<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        return view('welcome');
    }
}
