<?php

namespace App\Imports\Sheets;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TicketProcessSheet implements ToCollection, WithHeadingRow, WithBatchInserts
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $ticketProcess = DB::table('ticket_processes')->where([
                ['ticket_code', '=', $row['ticket_code']],
                ['status', '=', $row['status']],
            ])->first();

            if (empty($ticketProcess)) {
                DB::table('ticket_processes')->insert([
                    'ticket_code'   => $row['ticket_code'],
                    'status'        => $row['status'],
                    'user_id'       => $row['user_id'],
                    'update_date'   => date('Y-m-d H:i:s', strtotime($row['update_date'])),
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
            } else {
                DB::table('ticket_processes')->where([
                    ['ticket_code', '=', $row['ticket_code']],
                    ['status', '=', $row['status']],
                ])->update([
                    'status'        => $row['status'],
                    'user_id'       => $row['user_id'],
                    'update_date'   => date('Y-m-d H:i:s', strtotime($row['update_date'])),
                    'updated_at'    => date('Y-m-d H:i:s'),
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
