<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = DB::table('products')
            ->when($request->search, function (Builder $query, string $search) {
                $query->where('name', 'like', "%$search%");
            })->orderBy('name', 'asc')
            ->paginate(15);

        return Inertia::render('Product/Index', [
            'search' => $request->search ?? "",
            'products' => $products
        ]);
    }
}
