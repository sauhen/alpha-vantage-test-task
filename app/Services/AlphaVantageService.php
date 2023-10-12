<?php

namespace App\Services;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AlphaVantageService{
    protected $client;
    protected $apiKey;

    public function __construct(){
        $this->client = new Client([
            'base_uri' => 'https://www.alphavantage.co/'
        ]);

        $this->apiKey = config('services.alpha_vantage.api_key');
    }

    public function getStockPrice($symbol){
        try{
            $response = $this->client->get('query', [
                'query' => [
                    'function' => 'TIME_SERIES_INTRADAY',
                    'symbol' => $symbol,
                    'interval' => '1min',
                    'apikey' => $this->apiKey
                ],
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        }catch(RequestException $e){
            throw new \Exception('Error fetching stock price: ' . $e->getMessage(), $e->getCode());
        }
    }
}