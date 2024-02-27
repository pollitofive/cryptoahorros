<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountXCoinResource\Pages\CreateAccountXCoin;
use App\Filament\Resources\AccountXCoinResource\Pages\EditAccountXCoin;
use App\Filament\Resources\AccountXCoinResource\Pages\ListAccountXCoin;
use App\Models\Account;
use App\Models\AccountXCoin;
use App\Models\Coin;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AccountXCoinResource extends Resource
{
    protected static ?string $model = AccountXCoin::class;
    protected static ?string $label = "My Coins";
    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('account_id')
                    ->label('Account')
                    ->searchable()
                    ->required()
                    ->preload()
                    ->relationship('account', 'name', fn (Builder $query) => $query->where('user_id', auth()->id()))
                    ->createOptionForm(Account::getForm()),
                Select::make('coin_id')
                    ->label('Coin')
                    ->required()
                    ->searchable()
                    ->relationship('coin', 'name')
                    ->getOptionLabelFromRecordUsing(function (Coin $record) {
                        $label = "";
                        if($record->market_cap_rank) {
                            $label = "($record->market_cap_rank) ";
                        }
                        $label .= "{$record->name} ({$record->symbol})";
                        return $label;
                    }),
                Forms\Components\TextInput::make('amount')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('10s')
            ->columns([
                Tables\Columns\TextColumn::make('account.name')
                    ->sortable(),
                ViewColumn::make('Coin')->view('filament.tables.columns.coin-with-image'),
                Tables\Columns\TextColumn::make('amount')
                    ->state(function (AccountXCoin $record): string  {
                        return number_format($record->amount, 2);
                    })
                    ->alignRight(),
                Tables\Columns\TextColumn::make('Current price')
                    ->state(function (AccountXCoin $record): string  {
                        return 'USD '.number_format($record->coin->current_price,2);
                    })
                    ->alignRight(),
                Tables\Columns\TextColumn::make('Total By Coin')
                    ->state(function (AccountXCoin $record): string  {
                        return 'USD '.number_format($record->amount * $record->coin->current_price,2);
                    })
                    ->alignRight()
                    ->summarize(Tables\Columns\Summarizers\Summarizer::make()
                        ->label('Sum total of coins')
                        ->using(function () {
                            return "USD " . number_format(Coin::getSumAmountByPriceOfCoin(),2);
                        })
                    )
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->recordTitle("Coin"),
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
            'index' => ListAccountXCoin::route('/'),
            'create' => CreateAccountXCoin::route('/create'),
            'edit' => EditAccountXCoin::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('account', fn (Builder $query) => $query->where('user_id', auth()->id()));
    }
}
