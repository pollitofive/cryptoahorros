<?php

namespace App\Console\Commands;

use App\Classes\DollarInformation;
use App\Models\Dollar;
use App\Models\Quote;
use Goutte\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use voku\helper\HtmlDomParser;

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
        $type_dollars = Dollar::all();
        foreach($type_dollars as $dollar) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $dollar->url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            $html = curl_exec($curl);
            curl_close($curl);
            $htmlDomParser = HtmlDomParser::str_get_html($html);
            $values = $htmlDomParser->find(".value");

            $price_buy = $price_sell = 0;
            foreach($values as $key => $value)
            {
                if($key === 0) {
                    $price_buy = (float) str_replace("$","",$value->text);
                }

                if($key === 1) {
                    $price_sell = (float) str_replace("$","",$value->text);
                }
            }

            if($dollar->description === 'Dolar turista') {
                $price_sell = $price_buy;
                $price_buy = 0;
            }

            $quote = new Quote();
            $quote->dollar_id = $dollar->id;
            $quote->price_buy = $price_buy;
            $quote->price_sell = $price_sell;
            $quote->save();
        }
    }
}
