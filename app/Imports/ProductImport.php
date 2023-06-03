<?php

namespace App\Imports;

use App\Imports\Sheets\ProductSheet;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductImport implements WithMultipleSheets, SkipsUnknownSheets
{
    use WithConditionalSheets;

    public function sheets(): array
    {
        return [
            'barang' => new ProductSheet(),
        ];
    }

    public function conditionalSheets(): array
    {
        return [
            'barang' => new ProductSheet(),
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        info("Product Import - Sheet {$sheetName} was skipped");
    }
}
