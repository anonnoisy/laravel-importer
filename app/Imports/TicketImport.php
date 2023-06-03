<?php

namespace App\Imports;

use App\Imports\Sheets\TicketSheet;
use App\Imports\Sheets\TicketProcessSheet;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TicketImport implements WithMultipleSheets, SkipsUnknownSheets
{
    use WithConditionalSheets;

    public function sheets(): array
    {
        return [
            'ticket' => new TicketSheet(),
            'ticket_process' => new TicketProcessSheet(),
        ];
    }

    public function conditionalSheets(): array
    {
        return [
            'ticket' => new TicketSheet(),
            'ticket_process' => new TicketProcessSheet(),
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        info("Product Import - Sheet {$sheetName} was skipped");
    }
}
