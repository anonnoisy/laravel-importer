<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tickets = DB::table('tickets')
            ->when($request->search, function (Builder $query, string $search) {
                $query->where('code', 'like', "%$search%")
                    ->OrWhere('customer_id', 'like', "%$search%")
                    ->OrWhere('subject', 'like', "%$search%")
                    ->OrWhere('product_id', 'like', "%$search%");
            });

        if (!empty($request->daterange) && count($request->daterange) > 0) {
            $tickets = $tickets->where([
                ['ticket_date', '>=', date('Y-m-d 00:00:00', strtotime($request->daterange[0]))],
                ['ticket_date', '<=', date('Y-m-d 23:59:59', strtotime($request->daterange[1]))]
            ]);
        }

        $tickets = $tickets->paginate(15);

        return Inertia::render('Ticket/Index', [
            'search' => $request->search ?? "",
            'daterange' => $request->daterange ?? [],
            'tickets' => $tickets
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code)
    {
        $ticket = DB::table('tickets')
            ->select([
                'code',
                'customer_id as customer',
                'product_id',
                'subject',
                'issue',
                'ticket_date'
            ])->where('code', $code)
            ->first();

        $ticketProcesses = DB::table('ticket_processes')
            ->select(['status', 'user_id as user', 'update_date'])
            ->where('ticket_code', $code)
            ->get();

        return Inertia::render('Ticket/Show', [
            'ticket' => $ticket,
            'ticketProcesses' => $ticketProcesses
        ]);
    }
}
