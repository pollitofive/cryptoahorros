<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/*
https://api.coingecko.com/api/v3/simple/price?vs_currencies=usd&include_market_cap=true&include_24hr_change=true&ids=bitcoin,ethereum,tether,binancecoin,binance-peg-xrp,usd-coin,cardano,dogecoin,solana,the-open-network,dai,tron,polkadot,matic-network,litecoin,wrapped-bitcoin,shiba-inu,bitcoin-cash,chainlink,true-usd
https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=bitcoin,ethereum,tether,binancecoin,binance-peg-xrp,usd-coin,cardano,dogecoin,solana,the-open-network,dai,tron,polkadot,matic-network,litecoin,wrapped-bitcoin,shiba-inu,bitcoin-cash,chainlink,true-usd
https://api.coingecko.com/api/v3/simple/supported_vs_currencies
https://api.coingecko.com/api/v3/coins/bitcoin/history?date=19-09-2023



 * */


