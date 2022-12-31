<?php

namespace Exchange;

session_start();

include('login-check.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
    <script src="../resources/js/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.5.4/socket.io.js"
        integrity="sha512-YeeA/Qxn5hYdkukScTCNNOhTrv1C2RubAGButJ1rmgQwZf/HdRaCGl+JAVkqsqaNRaYNHdheiuKKuPf9mDcqKg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Exchange</title>
</head>

<body style="margin: 0px;">
    <!-- Insert html code here -->
    <div id="chart">
        <span class="crypto-price"></span>
        <span class="text"></span>
        <span class="candle-data"></span>
    </div>
</body>

</html>

<script>
let chartId = document.getElementById('chart');
let chartData = document.querySelector('.text');
let element = document.createElement('p');
let token = 'BTCBUSD';

const url = `wss://stream.binance.com:9443/stream?streams=btcbusd@trade/btcbusd@kline_1m`; //BUSD is our asset.
const socket = new WebSocket(url);

element.innerHTML = `
    <img style="vertical-align: middle;" src="https://cdn.jsdelivr.net/gh/vadimmalykhin/binance-icons/crypto/${token.replace('BUSD', '').toLowerCase()}.svg" alt="${token.replace('BUSD', '').toLowerCase()}"> <b>${token.replace('BUSD', '').toUpperCase()}/BUSD</b> <i class="fa-solid fa-grip-lines"></i>
    `;

chartData.appendChild(element);
var chart = LightweightCharts.createChart(chartId, {
    width: 1000,
    height: 1000,
    layout: {
        backgroundColor: 'transparent',
        textColor: '#6e6e71',
    },
    grid: {
        vertLines: {
            color: 'transparent',
        },
        horzLines: {
            color: 'transparent',
        },
    },
    crosshair: {
        mode: LightweightCharts.CrosshairMode.Normal,
    },
    rightPriceScale: {
        borderColor: '#6e6e71',
    },
    timeScale: {
        borderColor: '#6e6e71',
    },
});

var candleSeries = chart.addCandlestickSeries({
    upColor: '#1dd1a1',
    downColor: '#fb4e54',
    borderDownColor: '#fb4e54',
    borderUpColor: '#1dd1a1',
    wickDownColor: '#fb4e54',
    wickUpColor: '#1dd1a1',
});

let chartContainer = document.getElementById('chart')
new ResizeObserver(entries => {
    if (entries.length === 0 || entries[0].target !== chartContainer) {
        return;
    }
    const newRect = entries[0].contentRect;
    chart.applyOptions({
        height: newRect.height,
        width: newRect.width
    });
}).observe(chartContainer);

var start = new Date(Date.now() - (21600 * 1000));

var symbol = 'BTCBUSD';

var bars_URL =
    `https://api.binance.com/api/v3/uiKlines?startTime=${Math.floor(start.getTime())}&interval=1m&symbol=${symbol.toUpperCase()}`;

fetch(bars_URL, {

    }).then((r) => r.json())
    .then((response) => {
        const data = response.map(bar => ({
            open: bar[1],
            high: bar[2],
            low: bar[3],
            close: bar[4],
            time: bar[0] / 1000
        }));

        candleSeries.setData(data);
    });

let crypto_price = document.querySelector('.crypto-price');

var priceLines = [];
socket.onmessage = function name(event) {
    const rawdata = JSON.parse(event.data);
    const data = rawdata.data;

    let streamType = rawdata.stream.split('@')[1];
    let lastPrice = 0;
    if (streamType === 'kline_1m') {
        var bar = data.k;

        var baseDate = new Date(bar.T);
        var date = (new Date(baseDate.getFullYear(), baseDate.getMonth(), baseDate.getDate(), baseDate.getHours(),
            baseDate.getMinutes(), 0).getTime() / 1000);
        currentBar = {
            time: date,
            open: bar.o,
            high: bar.h,
            low: bar.l,
            close: bar.c
        };

        crypto_price.innerHTML = `<a style="color: red;"> ${bar.c}</a>`;
        if (bar.c > lastPrice) crypto_price.innerHTML = `<a style="color: green;"> ${bar.c}</a>`;
        lastPrice = bar.c;
        candleSeries.update(currentBar);
    }
}

let text = document.getElementById('candle-data');
chart.subscribeCrosshairMove(param => {
    if (param.time) {
        let candle = param.seriesPrices.get(candleSeries);
        let change = parseFloat(((candle.close - candle.open) / candle.open) * 100).toFixed(2)
        let amplitude = parseFloat(((candle.high - candle.low) / candle.high) * 100).toFixed(2)
        let open = parseFloat(candle.open).toFixed(2);
        let high = parseFloat(candle.high).toFixed(2);
        let low = parseFloat(candle.low).toFixed(2);
        let close = parseFloat(candle.close).toFixed(2);
        if (change > 0) {
            text.innerHTML =
                `Open: <a class="green">${open}</a> High: <a class="green">${high}</a> Low: <a class="green">${low}</a> Close: <a class="green">${close}</a> Change: <a class="green">+${change}</a> Amplitude: <a class="green">+${amplitude}</a>`
        } else {
            text.innerHTML =
                `Open: <a class="red">${open}</a> High: <a class="red">${high}</a> Low: <a class="red">${low}</a> Close: <a class="red">${close}</a> Change: <a class="red">${change}</a> Amplitude: <a class="red">${amplitude}</a>`
        }
    }
});

new ResizeObserver(entries => {
    if (entries.length === 0 || entries[0].target !== canvas) {
        return;
    }
    const newRect = entries[0].contentRect;
    canvas.width = canvas.parentElement.offsetWidth;
    canvas.height = canvas.parentElement.offsetHeight;
}).observe(canvas);
</script>