<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a chart of analytical.
     */
    public function index()
    {
        return Inertia::render('Dashboard/Index');
    }
}
