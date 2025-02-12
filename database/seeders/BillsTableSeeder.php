<?php

namespace Database\Seeders;

use App\Models\Bill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $denominations = [200, 100, 50, 20, 10, 5, 1];

        foreach ($denominations as $denomination) {
            Bill::create([
                'denomination' => $denomination,
                'quantity' => 10,
            ]);
        }
    }
}
