<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeyController extends Controller
{

    public function index()
    {
        return view('key');
    }

    public function dashboard()
    {
        return view('dashboard.key.dashboard');
    }
}
