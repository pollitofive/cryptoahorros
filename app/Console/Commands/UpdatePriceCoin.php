<?php

namespace App\Console\Commands;

use App\Connectors\Contracts\CoinPriceInterface;
use App\Models\Coin;
use App\Models\Market;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;

class UpdatePriceCoin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:price-coin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(protected CoinPriceInterface $coin_service)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $coins = Coin::orderBy('market_cap_rank')->take(1000)->get();
        $first_500 = $coins->take(500);
        $second_500 = $coins->take(-500);

        $this->find($first_500);
        $this->find($second_500);
    }

    private function find(Collection $coins): void
    {
        $this->coin_service->execute($coins);
    }
}
