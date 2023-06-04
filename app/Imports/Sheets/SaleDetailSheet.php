<?php

namespace App\Imports\Sheets;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SaleDetailSheet implements ToCollection, WithHeadingRow, WithBatchInserts
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $sale = DB::table('sales')->find($row['id_trx'], ['id']);
            $product = DB::table('products')->find($row['id_produk'], ['id']);

            if (!empty($sale) && !empty($product)) {
                DB::table('sale_details')->upsert([
                    'sale_id'           => (int) $row['id_trx'],
                    'invoice_number'    => $row['no_invoice'],
                    'product_id'        => (int) $row['id_produk'],
                    'qty'               => (int) $row['jml_barang'],
                    'weight'            => (float) $row['berat'],
                    'unit_price'        => (float) $row['harga_satuan'],
                    'discount'          => (float) $row['diskon'],
                    'total_price'       => (float) $row['harga'],
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
