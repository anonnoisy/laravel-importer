<?php

namespace App\Libraries\Notification;

enum NotificationStatus: string
{
  case DEFAULT  = 'DEFAULT';
  case INFO     = 'INFO';
  case SUCCESS  = 'SUCCESS';
  case WARNING  = 'WARNING';
  case ERROR    = 'ERROR';
}
