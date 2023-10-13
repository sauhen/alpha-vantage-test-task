<?php

namespace Tests\Feature;

use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class FetchStockPricesTest extends TestCase
{
    use RefreshDatabase;

    public function test_handle_method_fetches_stock_prices()
    {
        $alphaVantageServiceMock = $this->getMockBuilder(AlphaVantageService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->app->instance(AlphaVantageService::class, $alphaVantageServiceMock);

        $symbol = 'AAPL';
        $companyName = 'Apple Inc. Common Stock';
        Stock::factory()->create(['symbol' => $symbol, 'company_name' => $companyName]);

        Artisan::call('stock:fetch-prices');

        $this->assertDatabaseHas('stock_prices', ['stock_id' => 1]);
        $this->assertTrue(Cache::has("stock_price_{$symbol}"));
    }
}
