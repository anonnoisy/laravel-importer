<?php

namespace App\Imports\Sheets;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TicketSheet implements ToCollection, WithHeadingRow, WithBatchInserts
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            DB::table('tickets')->upsert([
                'code'          => $row['ticket_code'],
                'customer_id'   => $row['customer_id'],
                'product_id'    => $row['id_product'],
                'subject'       => $row['subject'],
                'issue'         => $row['issue'],
                'ticket_date'   => date('Y-m-d H:i:s', strtotime($row['ticket_date'])),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ], [
                'code',
            ], [
                'customer_id',
                'product_id',
                'subject',
                'issue',
                'ticket_date',
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
