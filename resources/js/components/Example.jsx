import axios from 'axios';
import Echo from 'laravel-echo';
import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';

function Example() {

    const [symbolsArray, setSymbolsArray] = useState([]);
    const [stockData, setStockData] = useState({});
    
    const fetchSymbols = async () => {
        try{
            const response = await axios.get('/api/stocks');
            setSymbolsArray(response.data);
        }catch(error){
            console.error('Error fetching symbols:', error);
        }
    }

    useEffect(() => {
        fetchSymbols();
    }, []);
    
    const fetchData = async () => {
        for (const symbol of symbolsArray) {
            const dataSymbol = symbol.symbol;
            const response = await axios.get(`/api/latest-stock-price/${dataSymbol}`);
            console.log(response.data);
            setStockData(prevData => ({
                ...prevData,
                [dataSymbol]: response.data
            }));            
        }
    }
    
    useEffect(() => {

        fetchData();

        console.log(stockData);

        const echo = new Echo({
            broadcaster: 'pusher',
            key: '0034101f512b9d5af941',
            cluster: 'eu',
            encrypted: true
        })

        symbolsArray.forEach(symbol => {
            echo.channel(`stock-price-channel.${symbol.symbol}`).listen('StockPriceUpdated', (event) => {
                console.log(event);
                setStockData(prevData => ({
                    ...prevData,
                    [symbol.symbol]: {
                        ...prevData[symbol.symbol],
                        stockPrices: [event, ...prevData[symbol.symbol].stockPrices]
                    }
                }));
            });
        });
    }, [symbolsArray]);

    const calculatePercentageChange = (latestPrice, previousPrice) => {
        if (!latestPrice || !previousPrice) return 0;
        const percentageChange = ((latestPrice.price - previousPrice.price) / previousPrice.price) * 100;
        return percentageChange.toFixed(2);
    };

    return (
        <div>
            {symbolsArray.map(symbol => {
                const stockDataForSymbol = stockData[symbol.symbol];
                if (!stockDataForSymbol) return null;

                const [latestPrice, previousPrice] = stockDataForSymbol.stockPrices;

                return (
                    <div key={symbol.symbol}>
                        <h2>Stock Symbol: {stockDataForSymbol.stock.symbol}</h2>
                        <p>Latest Price: {latestPrice.price}$</p>
                        <p>Percentage Change: {calculatePercentageChange(latestPrice, previousPrice)}%</p>
                    </div>
                );
            })}
        </div>
    );
}

export default Example;

if (document.getElementById('example')) {
    const Index = ReactDOM.createRoot(document.getElementById("example"));

    Index.render(
        <Example/>
    )
}
