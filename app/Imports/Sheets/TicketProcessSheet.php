<?php

namespace App\Imports\Sheets;

use App\Enums\TicketProcessStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TicketProcessSheet implements ToCollection, WithHeadingRow, WithBatchInserts, WithValidation
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
            ])->first(['ticket_code']);

            if (empty($ticketProcess)) {
                DB::table('ticket_processes')->insert([
                    'ticket_code'   => $row['ticket_code'],
                    'status'        => $row['status'],
                    'user_id'       => $row['user_id'],
                    'update_date'   => Date::excelToDateTimeObject($row['update_date'])->format('Y-m-d H:i:s'),
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
                    'update_date'   => Date::excelToDateTimeObject($row['update_date'])->format('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'status' => Rule::enum(TicketProcessStatus::class),
        ];
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
