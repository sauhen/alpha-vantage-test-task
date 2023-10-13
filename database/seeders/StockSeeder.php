<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['symbol' => 'AAPL', 'company_name' => 'Apple Inc. Common Stock'],
            ['symbol' => 'MSFT', 'company_name' => 'Microsoft Corporation Common Stock'],
            ['symbol' => 'AMZN', 'company_name' => 'Amazon.com, Inc. Common Stock'],
            ['symbol' => 'NVDA', 'company_name' => 'NVIDIA Corporation Common Stock'],
            ['symbol' => 'META', 'company_name' => 'Meta Platforms, Inc. Class A Common Stock'],
            ['symbol' => 'TSLA', 'company_name' => 'Tesla, Inc. Common Stock'],
            ['symbol' => 'WMT', 'company_name' => 'Walmart Inc. Common Stock'],
            ['symbol' => 'JPM', 'company_name' => 'JP Morgan Chase & Co. Common Stock'],
            ['symbol' => 'JNJ', 'company_name' => 'Johnson & Johnson Common Stock'],
            ['symbol' => 'MA', 'company_name' => 'Mastercard Incorporated Common Stock'],
        ];

        Stock::insert($data);
    }
}
