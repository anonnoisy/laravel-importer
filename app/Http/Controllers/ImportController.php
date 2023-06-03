<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportStoreRequest;
use App\Jobs\ImportJob;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = $request->excel;
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public', $filename);

        ImportJob::dispatch($filename);

        return to_route('dashboard')->with([
            'message' => 'Pengunggahan data sedang berlangsung.'
        ]);
    }
}
