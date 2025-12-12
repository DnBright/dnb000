<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "Dashboard Darkandbright";

        return view('dashboard.index', compact('title'));
    }
}
