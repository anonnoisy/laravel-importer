<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Http\Requests\ImportStoreRequest;
use App\Jobs\ImportJob;
use App\Libraries\Logger\ImportLogger;
use App\Libraries\Logger\ImportLoggerStatus;
use App\Libraries\Notification\Notification;
use App\Libraries\Notification\NotificationStatus;
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

        ImportLogger::build(
            file: $filename,
            path: 'public/',
        )->log();

        event(new NotificationEvent(
            auth()->user(),
            Notification::build(
                status: NotificationStatus::INFO,
                title: "Impor Data",
                message: "Sedang melakukan pengimporan data."
            )
        ));

        ImportJob::dispatch(auth()->user(), $filename);

        return to_route('dashboard');
    }
}
