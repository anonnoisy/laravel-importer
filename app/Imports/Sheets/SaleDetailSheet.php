<?php

namespace App\Imports\Sheets;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SaleDetailSheet implements ToCollection, WithHeadingRow, WithBatchInserts
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            DB::table('sale_details')->upsert([
                'sale_id'           => $row['id_trx'],
                'invoice_number'    => $row['no_invoice'],
                'product_id'        => $row['id_produk'],
                'qty'               => $row['jml_barang'],
                'weight'            => $row['berat'],
                'unit_price'        => $row['harga_satuan'],
                'discount'          => $row['diskon'],
                'total_price'       => $row['harga'],
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ], [
                'id',
                'sale_id',
                'invoice_number',
            ], [
                'product_id',
                'qty',
                'weight',
                'unit_price',
                'discount',
                'total_price',
                'updated_at',
            ]);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
