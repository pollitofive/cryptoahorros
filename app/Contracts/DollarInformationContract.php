<?php

namespace App\Contracts;

interface DollarInformationContract
{
    public function getUrlApi() : string;
    public function cleanData() : void;
    public function save() : void;
}
