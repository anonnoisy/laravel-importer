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
    public function index(Request $request)
    {
        $statistic = DB::table('sales')->select(DB::raw('
            COUNT(id) as total_sales,
            SUM(total_purchase_price) as total_revenue,
            COUNT(DISTINCT customer_id) as total_customer,
            (SELECT COUNT(code) FROM tickets) as total_ticket
        '))->first();

        $filters = $request->filter;

        $revenues = [];
        for ($year = $filters; $year >=  ($filters - 1); $year--) {
            $revenues[] = [
                'label' => "$year",
                'series' => DB::table('sales')->select(DB::raw('
                    YEAR(transaction_date) AS year,
                    MONTH(transaction_date) AS month_num,
                    DATE_FORMAT(transaction_date, "%M") AS month,
                    SUM(total_purchase_price) AS total_purchase_price
                '))->whereYear('transaction_date', $year)
                    ->groupBy('year', 'month_num', 'month')
                    ->orderBy(DB::raw('year, month_num'))
                    ->get(),
            ];
        }

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
            'filter' => $request->filter ?? date('Y'),
            'statistic' => $statistic,
            'revenues' => $revenues,
            'tickets' => $tickets,
            'sales' => $sales
        ]);
    }
}
