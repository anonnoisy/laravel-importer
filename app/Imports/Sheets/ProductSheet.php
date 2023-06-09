<?php

namespace App\Imports\Sheets;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductSheet implements ToCollection, WithHeadingRow, WithBatchInserts
{
	/**
	 * @param Collection $rows
	 */
	public function collection(Collection $rows)
	{
		foreach ($rows as $row) {
			DB::table('products')->upsert([
				'id'										=> (int) $row['id_produk'],
				'name'                  => $row['nama'],
				'product_category_id'   => (int) $row['id_kategori'],
				'weight'                => (float) $row['berat'],
				'stock'                 => (int) $row['stok'],
				'purchase_price'        => (float) $row['harga_beli'],
				'sell_price'            => (float) $row['harga_jual'],
				'created_at'            => date('Y-m-d H:i:s'),
				'updated_at'            => date('Y-m-d H:i:s'),
			], [
				'id',
				'name',
				'product_category_id',
			], [
				'weight',
				'stock',
				'purchase_price',
				'sell_price',
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
