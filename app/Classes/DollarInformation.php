<?php

namespace App\Classes;

use App\Contracts\DollarInformationContract;
use App\Models\Quote;
use App\Models\Dollar;
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
//        dd($this->data->Capital_Federal->casa6);
    }

    public function cleanData() : void
    {
        $data = $this->data;
        $type_dollars = Dollar::all();
        $array = [];
        foreach($type_dollars as $type) {
            $key = $type->key;
            $field = $type->category;
            $array[$type->id] = $data->$field->$key;
        }
        $this->cleaned_data = $array;
    }

    public function save() : void
    {
        foreach($this->cleaned_data as $dollar_id => $element) {
            $element = json_decode(json_encode($element));
//            dump($element);
            if(is_object($element)) {
                $price_buy = (float) str_replace('.', '', $element->compra);
                $price_sell = (float) str_replace('.', '', $element->venta);

                if($element->nombre === 'Blue') {
                    $price_buy = (float) str_replace(',', '', $element->compra);
                    $price_sell = (float) str_replace(',', '', $element->venta);
                }

//                dump($element->nombre, $price_buy, $price_sell);
                $quote = new Quote();
                $quote->dollar_id = $dollar_id;
                $quote->price_buy = $price_buy;
                $quote->price_sell = $price_sell;
                $quote->save();
            }
        }
    }
}
