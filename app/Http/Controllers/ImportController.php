<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Http\Requests\ImportStoreRequest;
use App\Jobs\ImportJob;
use App\Libraries\Logger\ImportLogger;
use App\Libraries\Logger\ImportLoggerStatus;
use App\Libraries\Notification\Notification;
use App\Libraries\Notification\NotificationStatus;
use App\Repositories\ImportRepository;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    private ImportRepository $importRepository;

    public function __construct()
    {
        $this->importRepository = new ImportRepository();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImportStoreRequest $request)
    {
        $this->importRepository->importing($request->path, $request->filename);

        return to_route('dashboard');
    }
}
