<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadStoreRequest;

class UploadController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadStoreRequest $request)
    {
        dd($request);
    }
}
