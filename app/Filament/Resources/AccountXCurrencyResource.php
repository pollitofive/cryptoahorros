<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountXCurrencyResource\Pages;
use App\Filament\Resources\AccountXCurrencyResource\Widgets\DollarPriceOverview;
use App\Models\Account;
use App\Models\AccountXCurrency;
use App\Models\Currency;
use App\Models\Quote;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AccountXCurrencyResource extends Resource
{
    protected static ?string $model = AccountXCurrency::class;
    protected static ?string $label = "My Currencies";

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('account_id')
                    ->label('Account')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->relationship('account', 'name', fn (Builder $query) => $query->where('user_id', auth()->id()))
                    ->createOptionForm(Account::getForm()),
                Select::make('currency_id')
                    ->label('Currency')
                    ->preload()
                    ->required()
                    ->searchable()
                    ->relationship('currency', 'name'),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->required()
                ->numeric()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('account.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency.name')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('amount')
                    ->state(function(AccountXCurrency $record): string {
                        return $record->currency->symbol . ' ' . number_format($record->amount,2);
                    })
                    ->alignRight()
                    ->numeric(),
                Tables\Columns\TextColumn::make('In Dollars')
                    ->tooltip(function($record)
                    {
                        if($record->currency->symbol == 'AR$') {
                            return "For exchange, you are using " . auth()->user()->dollar->description;
                        }

                        return "";
                    })
                    ->state(function (AccountXCurrency $record): string  {
                        if($record->currency->symbol == 'USD') {
                            return 'USD ' . number_format($record->amount,2);
                        }

                        return 'USD ' . number_format($record->amount / auth()->user()->price_dollar_selected,2);
                    })
                    ->numeric()
                    ->alignRight()
                    ->summarize(Tables\Columns\Summarizers\Summarizer::make()
                        ->label('Sum total in dollars')
                        ->using(function () {
                            return "USD " . number_format(Currency::getSumInDollars(),2);
                        })
                    )
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->recordTitle("Currency"),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccountXCurrencies::route('/'),
            'create' => Pages\CreateAccountXCurrency::route('/create'),
            'edit' => Pages\EditAccountXCurrency::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('account', fn (Builder $query) => $query->where('user_id', auth()->id()));
    }

}
