<?php

namespace App\Jobs;

use App\Events\NotificationEvent;
use App\Imports\BatchImport;
use App\Libraries\Logger\ImportLogger;
use App\Libraries\Logger\ImportLoggerStatus;
use App\Libraries\Notification\Notification;
use App\Libraries\Notification\NotificationStatus;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;
    protected string $file;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, string $file)
    {
        $this->user = $user;
        $this->file = $file;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $import = new BatchImport();
            $import->onlySheets('penjualan', 'barang', 'penjualan_detail', 'ticket', 'ticket_process');
            Excel::import($import, 'public/' . $this->file);

            ImportLogger::build(
                file: $this->file,
                path: 'public/',
                status: ImportLoggerStatus::DONE,
                user: $this->user,
            )->log();

            event(new NotificationEvent(
                $this->user,
                Notification::build(
                    title: "Impor Data",
                    message: "Berhasil mengimpor data.",
                    status: NotificationStatus::SUCCESS,
                )
            ));
        } catch (\Throwable $th) {
            ImportLogger::build(
                file: $this->file,
                path: 'public/',
                logMessage: $th->getMessage(),
                status: ImportLoggerStatus::ERROR,
                user: $this->user,
            )->log();

            event(new NotificationEvent(
                $this->user,
                Notification::build(
                    title: "Gagal Impor Data",
                    message: $th->getMessage(),
                    data: [
                        $th
                    ],
                    status: NotificationStatus::ERROR,
                )
            ));
        }
    }
}
