<?php

namespace App\Repositories;

use App\Events\NotificationEvent;
use App\Jobs\ImportJob;
use App\Libraries\Logger\ImportLogger;
use App\Libraries\Notification\Notification;
use App\Libraries\Notification\NotificationStatus;

class ImportRepository
{
	public function importing(string $path, string $filename): bool
	{
		try {
			if (!empty(auth()->user())) {
				ImportLogger::build(
					file: $filename,
					path: $path,
				)->log();

				event(new NotificationEvent(
					Notification::build(
						status: NotificationStatus::DEFAULT,
						title: "Impor Data",
						message: "Sedang melakukan pengimporan data."
					),
					auth()->user()
				));
			}

			ImportJob::dispatch($path, $filename, auth()->user() ?? NULL);

			return true;
		} catch (\Throwable $th) {
			throw $th;
		}
	}
}
