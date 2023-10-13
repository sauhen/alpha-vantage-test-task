<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StockPriceController extends Controller
{
    public function getAllSymbols(){
        $symbols = Stock::take(5)->get();
        return response()->json($symbols);
    }

    public function latestStockPrice($symbol){
        $cacheKey = "stock_data_{$symbol}";

        if(Cache::has($cacheKey)){
            $stockData = Cache::get($cacheKey);
        }else{
            $stock = Stock::where('symbol', $symbol)->first();

            if(!$stock){
                return response()->json(['error' => 'Stock not found'], 404);
            }

            $stockPrices = StockPrice::where('stock_id', $stock->id)->latest()->take(2)->get();

            $stockData = [
                'stock' => $stock,
                'stockPrices' => $stockPrices
            ];

            Cache::put($cacheKey, $stockData, now()->addMinutes(1));
        }
        

        return response()->json($stockData);
    }
}
