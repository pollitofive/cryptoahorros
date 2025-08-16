<?php

namespace App\Providers;

use App\Connectors\API\DolarHoyPriceService;
use App\Connectors\Contracts\DollarPriceInterface;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * @throws \ReflectionException
     */
    public function register(): void
    {
        app()->bind(DollarPriceInterface::class,DolarHoyPriceService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentColor::register([
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'primary' => Color::Amber,
            'success' => Color::Green,
            'warning' => Color::Amber,
        ]);
    }
}
