<?php

namespace App\Imports;

use App\Imports\Sheets\ProductSheet;
use App\Imports\Sheets\SaleDetailSheet;
use App\Imports\Sheets\SaleSheet;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SaleImport implements WithMultipleSheets, SkipsUnknownSheets, SkipsOnFailure
{
    use WithConditionalSheets, SkipsFailures;

    public function sheets(): array
    {
        return [
            0 => new SaleSheet(),
            2 => new ProductSheet(),
            1 => new SaleDetailSheet(),
        ];
    }

    public function conditionalSheets(): array
    {
        return [
            'penjualan' => new SaleSheet(),
            'barang' => new ProductSheet(),
            'penjualan_detail' => new SaleDetailSheet(),
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        info("Sale Import - Sheet {$sheetName} was skipped");
    }
}
