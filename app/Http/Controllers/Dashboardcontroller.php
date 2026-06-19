<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboardcontroller extends Controller
{
    public function index()
    {
        // Ini yang akan memanggil file resources/views/dashboard/index.blade.php
        return view('dashboard.index');
    }
}

