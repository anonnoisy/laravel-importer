<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a chart of analytical.
     */
    public function index()
    {
        $sales = DB::table('sales')->paginate(15);
        return Inertia::render('Dashboard/Index', [
            'sales' => $sales
        ]);
    }
}
