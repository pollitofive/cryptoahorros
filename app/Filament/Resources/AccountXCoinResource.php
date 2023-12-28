<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountXCoinxCurrencyResource\Pages;
use App\Filament\Resources\AccountXCoinxCurrencyResource\RelationManagers;
use App\Models\Account;
use App\Models\AccountXCoin;
use App\Models\Coin;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccountXCoinResource extends Resource
{
    protected static ?string $model = AccountXCoin::class;
    protected static ?string $label = "Coins";
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('account_id')
                    ->label('Account')
                    ->searchable()
                    ->preload()
                    ->relationship('account', 'name')
                    ->createOptionForm(Account::getForm()),
                Select::make('coin_id')
                    ->label('Coin')
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
            ->columns([
                Tables\Columns\TextColumn::make('account.name')
                    ->sortable(),
                ViewColumn::make('Coin')->view('filament.tables.columns.coin-with-image'),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAccountXCoinxCurrencies::route('/'),
            'create' => Pages\CreateAccountXCoinxCurrency::route('/create'),
            'edit' => Pages\EditAccountXCoinxCurrency::route('/{record}/edit'),
        ];
    }
}
