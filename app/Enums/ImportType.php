<?php

namespace App\Enums;

enum ImportType: string
{
  case BATCH    = 'BATCH';
  case SALE     = 'SALE';
  case PRODUCT  = 'PRODUCT';
  case TICKET   = 'TICKET';
}
