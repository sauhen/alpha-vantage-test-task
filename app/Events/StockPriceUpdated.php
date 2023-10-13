<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockPriceUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $symbol;
    public $stockData;

    /**
     * Create a new event instance.
     */
    public function __construct($symbol, $stockData)
    {
        $this->symbol = $symbol;
        $this->stockData = $stockData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel('stock-price-channel.'.$this->symbol);
    }

    public function broadcastWith(): array
    {
        return $this->stockData;
    }
}
