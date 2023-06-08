<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a chart of analytical.
     */
    public function index(Request $request)
    {
        $filter = (int) $request->filter ?? date('Y');

        $statistic = Sale::getStats();
        $revenues = Sale::getChartRevenues((int) $filter);

        $sales = DB::table('sales')
            ->orderBy('transaction_date', 'desc')
            ->limit(5)
            ->get();

        $tickets = DB::table('tickets')
            ->orderBy('ticket_date', 'desc')
            ->limit(5)
            ->get();

        return Inertia::render('Dashboard/Index', [
            'filter' => $filter,
            'statistic' => $statistic,
            'revenues' => $revenues,
            'tickets' => $tickets,
            'sales' => $sales
        ]);
    }
}
