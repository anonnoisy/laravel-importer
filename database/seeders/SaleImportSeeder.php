<?php

namespace Database\Seeders;

use App\Repositories\ImportRepository;
use Illuminate\Database\Seeder;

class SaleImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $importRepository = new ImportRepository();
        $importRepository->importing('dataset/', 'transaksi.xslx');
    }
}
