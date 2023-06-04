<?php

namespace App\Libraries\Logger;

enum ImportLoggerStatus: string
{
  case START = 'START';
  case ERROR = 'ERROR';
  case DONE  = 'DONE';
}
