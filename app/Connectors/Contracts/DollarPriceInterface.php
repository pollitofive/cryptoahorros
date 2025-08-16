<?php

namespace App\Connectors\Contracts;

interface DollarPriceInterface
{
    public function getUrls(): array;
    public function execute(): void;
}
