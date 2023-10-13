<?php

namespace Tests\Unit;

use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class StockModelTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_stock_model_creation()
    {
        $stock = Stock::factory()->create([
            'symbol' => 'AAPL',
            'company_name' => 'Apple Inc.'
        ]);

        $this->assertNotNull($stock);
        $this->assertEquals('AAPL', $stock->symbol);
        $this->assertEquals('Apple Inc.', $stock->company_name);
    }
}
