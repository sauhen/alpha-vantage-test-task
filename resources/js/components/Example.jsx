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

            setStockData(prevData => ({
                ...prevData,
                [dataSymbol]: response.data
            }));            
        }
    }
    
    useEffect(() => {

        fetchData();

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
                    [symbol.symbol]: event
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
        <table className='stock-table'>
            <thead>
                <tr className='stock-table__caption'>
                    <td className="symbol">Symbol</td>
                    <td className="company">Company name</td>
                    <td className="latest-price">Latest Price</td>
                    <td className="percentage-change">%</td>
                    <td className="ico"></td>
                </tr>
            </thead>
            <tbody>
                {symbolsArray.map(symbol => {
                    const stockDataForSymbol = stockData[symbol.symbol];
                    if (!stockDataForSymbol) return null;

                    const [latestPrice, previousPrice] = stockDataForSymbol.stockPrices;
                    const percantegeChange = calculatePercentageChange(latestPrice, previousPrice);

                    return (
                        <tr key={symbol.symbol} className='stock-table__line'>
                            <td>{stockDataForSymbol.stock.symbol}</td>
                            <td>{stockDataForSymbol.stock.company_name}</td>
                            <td className="latest-price">{latestPrice.price}$</td>
                            <td className="percentage-change">{percantegeChange}%</td>
                            <td className="ico">{percantegeChange >= 0 ? '↑' : '↓'}</td>
                        </tr>
                    );
                })}
            </tbody>
        </table>
    );
}

export default Example;

if (document.getElementById('example')) {
    const Index = ReactDOM.createRoot(document.getElementById("example"));

    Index.render(
        <Example/>
    )
}
