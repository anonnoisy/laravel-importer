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

    protected User|null $user;
    protected string $path;
    protected string $filename;

    /**
     * Create a new job instance.
     */
    public function __construct(string $path, string $filename, User|null $user = NULL)
    {
        $this->path = $path;
        $this->filename = $filename;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $import = new BatchImport();
            $import->onlySheets('penjualan', 'barang', 'penjualan_detail', 'ticket', 'ticket_process');
            Excel::import($import, $this->path . $this->filename);

            if (!empty($this->user)) {
                $this->logAndNotify(
                    title: "Impor Data",
                    message: "Data telah berhasil diimport.",
                    status: ImportLoggerStatus::DONE
                );
            }
        } catch (\Throwable $th) {
            if (!empty($this->user)) {
                $this->logAndNotify(
                    title: "Gagal mengimport data",
                    message: $th->getMessage(),
                    status: ImportLoggerStatus::ERROR
                );
            }
        }
    }

    private function logAndNotify(
        string $title,
        string $message,
        ImportLoggerStatus $status = ImportLoggerStatus::DONE,
        array $data = []
    ) {
        ImportLogger::build(
            file: $this->filename,
            path: $this->path,
            logMessage: $message,
            status: $status,
            user: $this->user,
        )->log();

        event(new NotificationEvent(
            Notification::build(
                title: $title,
                message: $message,
                data: $data,
                status: $status === ImportLoggerStatus::DONE ? NotificationStatus::SUCCESS : NotificationStatus::ERROR,
            ),
            $this->user
        ));
    }
}
