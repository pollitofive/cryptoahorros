<?php

namespace App\Connectors\API;

use App\Connectors\Contracts\DollarPriceInterface;
use App\Models\Dollar;
use App\Models\Quote;
use voku\helper\HtmlDomParser;
use voku\helper\SimpleHtmlDomNode;

class DolarHoyPriceService implements DollarPriceInterface
{
    protected string $url = 'https://dolarhoy.com/';
    public function getUrls(): array
    {
        return [
            'Dolar oficial' => $this->url . 'cotizaciondolaroficial',
            'Dolar blue' => $this->url . 'cotizaciondolarblue',
            'Dolar bolsa' => $this->url . 'cotizaciondolarbolsa',
            'Dolar turista' => $this->url . 'cotizacion-dolar-tarjeta',
        ];
    }

    public function execute(): void
    {
        $type_dollars = Dollar::all();
        foreach($type_dollars as $dollar) {
            $values = $this->executeCurl($dollar->description);

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

            Quote::create($dollar->id, $price_buy, $price_sell);
        }
    }

    private function executeCurl(string $dollar_description): SimpleHtmlDomNode
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->getUrls()[$dollar_description]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        $html = curl_exec($curl);
        curl_close($curl);
        $htmlDomParser = HtmlDomParser::str_get_html($html);
        return $htmlDomParser->find(".value");
    }
}
