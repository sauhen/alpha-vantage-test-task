<?php

namespace App\Console\Commands;

use App\Events\StockPriceUpdated;
use App\Models\Stock;
use App\Models\StockPrice;
use App\Services\AlphaVantageService;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class FetchStockPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:fetch-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch stock prices from Alpha Vantage';

    protected $alphaVantageService;

    public function __construct(AlphaVantageService $alphaVantageService){
        parent::__construct();
        $this->alphaVantageService = $alphaVantageService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {        
        $stocks = Stock::all();

        foreach($stocks as $stock){
            $symbol = $stock->symbol;
            
            if ($this->exceededRateLimit()) {
                $this->error('API rate limit exceeded. Please try again later.');
                return;
            }
            
            $key = 'Time Series (1min)';
            
            try{
                $response = $this->alphaVantageService->getStockPrice($symbol);

                if(isset($response[$key])){
                    $latestPrice = current($response[$key]);
                    $latestPriceKey = '4. close';

                    $date = key($response[$key]);
    
                    StockPrice::create([
                        'stock_id' => $stock->id,
                        'price' => $latestPrice[$latestPriceKey],
                        'date' => $date
                    ]);

                    $cacheKey = "stock_price_{$symbol}";
                    $stockPrices = StockPrice::where('stock_id', $stock->id)->latest()->take(2)->get();

                    $stockData = [
                        'stock' => $stock,
                        'stockPrices' => $stockPrices
                    ];
        
                    Cache::put($cacheKey, $stockData, now()->addMinutes(1));

                    broadcast(new StockPriceUpdated($symbol, $stockData))->toOthers();
    
                    $this->info("Fetched stock price for {$symbol} at {$date}");
                } else {
                    $this->error("Failed to fetch stock price for {$symbol}");
                }
            }catch(Exception $e){
                $this->error("An error occurred while fetching stock price for {$symbol}: " . $e->getMessage());
            }

        }
    }

    private function exceededRateLimit()
    {
        $requestsPerMinuteLimit = 5;
        $requestsPerDayLimit = 100;

        $currentTime = now();

        $lastRequestTimestamp = $this->getLastRequestTimestamp();
        $totalRequestsToday = $this->getTotalRequestsToday();

        $minutePassed = $currentTime->diffInMinutes($lastRequestTimestamp);

        $requestsWithinLastMinute = $this->getRequestsWithinLastMinute($currentTime);

        if(!$lastRequestTimestamp || !$currentTime->isSameDay($lastRequestTimestamp)){
            $totalRequestsToday = 0;
        }
        
        if ($requestsWithinLastMinute >= $requestsPerMinuteLimit) {
            return true; 
        }

        if($minutePassed < 1 && $totalRequestsToday >= $requestsPerDayLimit){
            return true;
        }

        $totalRequestsToday++;
        $lastRequestTimestamp = $currentTime;

        return false;

    }

    private function getRequestsWithinLastMinute($currentTime){
        return StockPrice::where('created_at', '>=', $currentTime->subMinute())->count();
    }

    private function getLastRequestTimestamp()
    {
        $latestStockPrice = StockPrice::latest()->first();

        if($latestStockPrice){
            return $latestStockPrice->created_at;
        }

        return null;
    }

    private function getTotalRequestsToday()
    {
        $today = Carbon::now()->startOfDay();
        return StockPrice::whereDate('created_at', $today)->count();
    }
}
