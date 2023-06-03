<?php

namespace App\Imports;

use App\Imports\Sheets\ProductSheet;
use App\Imports\Sheets\SaleDetailSheet;
use App\Imports\Sheets\SaleSheet;
use App\Imports\Sheets\TicketProcessSheet;
use App\Imports\Sheets\TicketSheet;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BatchImport implements WithMultipleSheets, SkipsOnFailure
{
    use WithConditionalSheets, SkipsFailures;

    public function conditionalSheets(): array
    {
        return [
            'penjualan'         => new SaleSheet(),
            'barang'            => new ProductSheet(),
            'penjualan_detail'  => new SaleDetailSheet(),
            'ticket'            => new TicketSheet(),
            'ticket_process'    => new TicketProcessSheet()
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        info("Sheet {$sheetName} was skipped");
    }
}
