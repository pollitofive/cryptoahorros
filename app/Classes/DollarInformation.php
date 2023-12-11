<?php

namespace App\Classes;

use App\Contracts\DollarInformationContract;
use App\Models\Quote;
use App\Models\TypeDollar;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

class DollarInformation implements DollarInformationContract
{
    protected SimpleXMLElement $data;
    protected array $cleaned_data;

    public function getUrlApi() : string
    {
        return config('constants.API_DOLLAR');
    }

    public function __construct()
    {
        $data = Http::withoutVerifying()->get($this->getUrlApi());
        $this->data = simplexml_load_string($data->body());
    }

    public function cleanData() : void
    {
        $data = $this->data;
        $type_dollars = TypeDollar::all();
        $array = [];
        foreach($type_dollars as $type) {
            $key = $type->key;
            $array[$type->id] = $data->valores_principales->$key;
        }
        $this->cleaned_data = $array;
    }

    public function save() : void
    {
        foreach($this->cleaned_data as $type_dollar_id => $element) {
            $price_buy = str_replace(',', '.', $element->compra);
            $price_buy = is_numeric($price_buy) ? $price_buy : 0;

            $price_sell = str_replace(',', '.', $element->venta);
            $price_sell = is_numeric($price_sell) ? $price_sell : 0;

            $quote = new Quote();
            $quote->type_dollar_id = $type_dollar_id;
            $quote->price_buy = $price_buy;
            $quote->price_sell = $price_sell;
            $quote->save();
        }
    }
}
