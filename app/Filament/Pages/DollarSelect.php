<?php

namespace App\Filament\Pages;

use App\Models\Dollar;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class DollarSelect extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static string $view = 'filament.pages.dollar-select';

    protected static ?string $title = 'Dollar Selected';

    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Select::make('dollar_selected')
                    ->label('Dolar seleccionado')
                    ->required()
                    ->options(Dollar::all()->pluck('description', 'id'))
                    ->searchable()
                    ->default(auth()->user()->dollar_selected)
                ,
                Select::make('compra_venta')
                    ->label('¿Compra o venta?')
                    ->options([
                        'price_buy' => 'Compra',
                        'price_sell' => 'Venta'
                    ])
                ->default(auth()->user()->compra_venta)
                ->required()
            ])
            ->statePath('data');
    }

    public function update(): void
    {
        User::where('id', auth()->id())->update($this->data);
        auth()->user()->update($this->data);

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }
}
