<?php

namespace App\Libraries\Notification;

class Notification
{
	private static Notification $notification;

	private function __construct(
		private string $title,
		private string $message,
		private array | null $data = null,
		private NotificationStatus $status = NotificationStatus::DEFAULT
	) {
	}

	public static function build(
		string $title,
		string $message,
		array | null $data = null,
		NotificationStatus $status = NotificationStatus::DEFAULT,
	) {
		if (empty(self::$notification)) {
			return new Notification($title, $message, $data, $status);
		}

		return self::$notification;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function setTitle(string $title): Notification
	{
		$this->title = $title;
		return $this;
	}

	public function getMessage(): string
	{
		return $this->message;
	}

	public function setMessage(string $message): Notification
	{
		$this->message = $message;
		return $this;
	}

	public function getData(): array
	{
		return $this->data;
	}

	public function setData(array $data): Notification
	{
		$this->data = $data;
		return $this;
	}

	public function getBody(): object
	{
		return (object) [
			'status' => $this->status,
			'title' => $this->title,
			'message' => $this->message,
			'data' => $this->data,
		];
	}
}
