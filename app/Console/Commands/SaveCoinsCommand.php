<?php

namespace App\Console\Commands;

use App\Models\Coin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SaveCoinsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save-coins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $coins = Http::get("https://api.coingecko.com/api/v3/coins/list")->json();
        foreach($coins as $coin) {
            Coin::create([
                'key' => $coin['id'],
                'symbol' => $coin['symbol'],
                'name' => $coin['name']
            ]);
        }
    }
}
