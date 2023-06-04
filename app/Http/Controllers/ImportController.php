<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Http\Requests\ImportStoreRequest;
use App\Jobs\ImportJob;
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

        event(new NotificationEvent(
            auth()->user(),
            Notification::build(
                status: NotificationStatus::INFO,
                title: "Impor Data",
                message: "Sedang melakukan pengimporan data."
            )
        ));

        ImportJob::dispatchSync(auth()->user(), $filename);

        return to_route('dashboard')->with([
            'message' => 'Pengunggahan data sedang berlangsung.'
        ]);
    }

    public function notification()
    {
        event(new NotificationEvent(
            auth()->user(),
            Notification::build(
                title: "Broadcast Event",
                message: "This is broadcast event",
                data: [],
                status: NotificationStatus::WARNING,
            )
        ));
    }
}
