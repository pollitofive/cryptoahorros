<?php

namespace App\Console\Commands;

use App\Classes\DollarInformation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dollar_information = new DollarInformation();
        $dollar_information->cleanData();
        $dollar_information->save();
    }
}
