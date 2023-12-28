<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountXCurrencyResource\Pages;
use App\Filament\Resources\AccountXCurrencyResource\RelationManagers;
use App\Models\Account;
use App\Models\AccountXCurrency;
use App\Models\Coin;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccountXCurrencyResource extends Resource
{
    protected static ?string $model = AccountXCurrency::class;
    protected static ?string $label = "Currencies";

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
                Select::make('currency_id')
                    ->label('Currency')
                    ->preload()
                    ->searchable()
                    ->relationship('currency', 'name'),
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
                Tables\Columns\TextColumn::make('currency.name')
                    ->sortable(),
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
            'index' => Pages\ListAccountXCurrencies::route('/'),
            'create' => Pages\CreateAccountXCurrency::route('/create'),
            'edit' => Pages\EditAccountXCurrency::route('/{record}/edit'),
        ];
    }
}
