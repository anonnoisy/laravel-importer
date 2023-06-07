<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sales = DB::table('sales')
            ->when($request->search, function (Builder $query, string $search) {
                $query->where('invoice_number', 'like', "%$search%")
                    ->OrWhere('customer_id', 'like', "%$search%")
                    ->OrWhere('shipping_type', 'like', "%$search%");
            });

        if (!empty($request->shipping_date) && count($request->shipping_date) > 0) {
            $sales = $sales->where([
                ['shipping_date', '>=', date('Y-m-d 00:00:00', strtotime($request->shipping_date[0]))],
                ['shipping_date', '<=', date('Y-m-d 23:59:59', strtotime($request->shipping_date[1]))]
            ]);
        }

        if (!empty($request->transaction_date) && count($request->transaction_date) > 0) {
            $sales = $sales->where([
                ['transaction_date', '>=', date('Y-m-d 00:00:00', strtotime($request->transaction_date[0]))],
                ['transaction_date', '<=', date('Y-m-d 23:59:59', strtotime($request->transaction_date[1]))]
            ]);
        }

        $sales = $sales
            ->orderBy('shipping_date', 'desc')
            ->paginate(15);

        return Inertia::render('Sales/Index', [
            'search' => $request->search ?? "",
            'shippingDate' => $request->shipping_date ?? [],
            'transactionDate' => $request->transaction_date ?? [],
            'sales' => $sales,
        ]);
    }

    /**
     * Display the specified resource.
     * 
     * @param string $invoice_number
     */
    public function show(string $invoice_number)
    {
        $sale = DB::table('sales')
            ->where('invoice_number', $invoice_number)
            ->first();

        $products = DB::table('sale_details as sd')
            ->select([
                'sd.id',
                'sd.sale_id',
                'p.name',
                'p.product_category_id as category',
                'sd.qty',
                'sd.weight',
                'sd.unit_price as price',
                'sd.discount',
                'sd.total_price as total'
            ])->join('products as p', 'sd.product_id', '=', 'p.id')
            ->where('sale_id', $sale->id)
            ->get();

        return Inertia::render('Sales/Show', [
            'sale' => $sale,
            'products' => $products,
        ]);
    }
}
