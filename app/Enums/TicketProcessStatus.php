<?php

namespace App\Enums;

enum TicketProcessStatus: string
{
  case OPEN     = 'OPEN';
  case REVIEW   = 'REVIEW';
  case RESOLVED = 'RESOLVED';
  case TRANSFER = 'TRANSFER';
  case CLOSED   = 'CLOSED';
}
