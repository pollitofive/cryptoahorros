<?php

namespace App\Console\Commands;

use App\Connectors\Contracts\DollarPriceInterface;
use Illuminate\Console\Command;

class DollarUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dolar:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the prices of the dollars';

    public function __construct(protected DollarPriceInterface $dollar_service)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->dollar_service->execute();
    }
}
