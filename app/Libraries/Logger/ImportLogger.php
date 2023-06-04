<?php

namespace App\Libraries\Logger;

use App\Enums\ImportType;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ImportLogger
{
	private static ImportLogger|NULL $logger = NULL;

	private int $loggerId;

	private User $user;
	private ImportLoggerStatus $status;
	private ImportType $type;
	private string $file;
	private string $path;
	private string $logMessage;

	private function __construct(
		string $file,
		string $path,
		string $logMessage,
		ImportLoggerStatus $status,
		ImportType $type,
		User|null $user = NULL
	) {
		$this->file = $file;
		$this->path = $path;
		$this->logMessage = $logMessage;
		$this->type = $type;
		$this->status = $status;

		if (empty($user)) {
			$this->user = auth()->user();
		} else {
			$this->user = $user;
		}
	}

	public static function build(
		string $file,
		string $path,
		string $logMessage = "",
		ImportLoggerStatus $status = ImportLoggerStatus::START,
		ImportType $type = ImportType::BATCH,
		User|null $user = NULL
	) {
		if (self::$logger) {
			return self::$logger;
		}

		self::$logger = new ImportLogger($file, $path, $logMessage, $status, $type, $user);
		return self::$logger;
	}

	public function log()
	{
		$this->loggerId = DB::table('import_loggers')->insertGetId([
			'file' => $this->file,
			'path' => $this->path,
			'logs' => $this->logMessage,
			'status' => $this->status,
			'type' => $this->type,
			'import_by' => $this->user->id,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		]);

		return $this;
	}

	public function getLog()
	{
		return DB::table('import_loggers')->where('id', $this->loggerId)->first();
	}
}
