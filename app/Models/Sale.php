<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'invoice_number',
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
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'shipping_date' => 'datetime',
        'transaction_date' => 'datetime',
    ];

    public static function getStats(): object
    {
        return DB::table('sales')->select(DB::raw('
            COUNT(id) as total_sales,
            SUM(total_purchase_price) as total_revenue,
            COUNT(DISTINCT customer_id) as total_customer,
            (SELECT COUNT(code) FROM tickets) as total_ticket
        '))->first();
    }

    public static function getChartRevenues(int $filter): array
    {
        $query = function (int $year) {
            return DB::table('sales')->select(DB::raw('
                    YEAR(transaction_date) AS year,
                    MONTH(transaction_date) AS month_num,
                    DATE_FORMAT(transaction_date, "%M") AS month,
                    SUM(total_purchase_price) AS total_purchase_price
                '))->whereYear('transaction_date', $year)
                ->groupBy('year', 'month_num', 'month')
                ->orderBy(DB::raw('year, month_num'))
                ->get();
        };

        $revenues = [];
        for ($year = $filter; $year >=  ($filter - 1); $year--) {
            $revenues[] = [
                'label' => "$year",
                'series' => $query($year),
            ];
        }

        return $revenues;
    }
}
