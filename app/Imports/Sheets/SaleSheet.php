<?php

namespace App\Imports\Sheets;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SaleSheet implements ToCollection, WithHeadingRow, WithBatchInserts
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!empty($row['id_trx'])) {
                DB::table('sales')->upsert([
                    'id'                    => (int) $row['id_trx'],
                    'invoice_number'        => $row['no_invoice'],
                    'weight_total'          => (float) $row['total_berat'],
                    'shipping_cost'         => (float) $row['ongkos_kirim'],
                    'total_price'           => (float) $row['total_harga'],
                    'total_purchase_price'  => (float) $row['total_harga_beli'],
                    'customer_id'           => (int) $row['kode_user'],
                    'shipping_address'      => $row['alamat_penerima'],
                    'shipping_service_id'   => (int) $row['id_ekspedisi'],
                    'shipping_type'         => $row['jenis_pengiriman'],
                    'shipping_date'         => Date::excelToDateTimeObject($row['tgl_kirim'])->format('Y-m-d H:i:s'),
                    'transaction_date'      => Date::excelToDateTimeObject($row['tgl_trx'])->format('Y-m-d H:i:s'),
                    'created_at'            => date('Y-m-d H:i:s'),
                    'updated_at'            => date('Y-m-d H:i:s'),
                ], [
                    'id',
                    'invoice_number'
                ], [
                    'weight_total',
                    'shipping_cost',
                    'total_price',
                    'total_purchase_price',
                    'customer_id',
                    'shipping_address',
                    'shipping_service_id',
                    'shipping_type',
                    'shipping_date',
                    'transaction_date',
                    'updated_at'
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
