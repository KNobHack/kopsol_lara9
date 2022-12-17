<?php

namespace App\Http\Controllers\Central;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('central.dashboard.dashboard');
    }
}
