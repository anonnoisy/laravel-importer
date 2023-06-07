<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\Builder;
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
        $statistic = DB::table('sales')->select(DB::raw('
            COUNT(id) as total_sales,
            SUM(total_purchase_price) as total_revenue,
            COUNT(DISTINCT customer_id) as total_customer,
            (SELECT COUNT(code) FROM tickets) as total_ticket
        '))->first();

        $sales = DB::table('sales')
            ->orderBy('transaction_date', 'desc')
            ->limit(5)
            ->get();

        $tickets = DB::table('tickets')
            ->orderBy('ticket_date', 'desc')
            ->limit(5)
            ->get();

        return Inertia::render('Dashboard/Index', [
            'search' => $request->search ?? "",
            'statistic' => $statistic,
            'tickets' => $tickets,
            'sales' => $sales
        ]);
    }
}
