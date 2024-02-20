<?php

namespace Tests\Feature;

use App\Filament\Resources\AccountXCurrencyResource;
use App\Models\Account;
use App\Models\AccountXCurrency;
use App\Models\Currency;
use App\Models\Dollar;
use App\Models\Quote;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use function Pest\Livewire\livewire;

beforeEach(function(){
    $this->actingAs(User::factory()->create());
    Account::factory()->create([
        'user_id' => auth()->id()
    ]);

    Currency::factory()->create([
        'name' => 'Argentinian Peso',
        'symbol' => 'AR$',
    ]);

    Currency::factory()->create([
        'name' => 'Dollars',
        'symbol' => 'USD',
    ]);

    Dollar::factory()->create([
        'description' => 'Dolar oficial',
        'url' => '',
    ]);

    Dollar::factory()->create([
        'description' => 'Dolar blue',
        'url' => '',
    ]);

    Dollar::factory()->create([
        'description' => 'Dolar bolsa',
        'url' => '',
    ]);

    Dollar::factory()->create([
        'description' => 'Dolar turista',
        'url' => '',
    ]);

    Quote::factory()->create([
        'dollar_id' => 1,
        'price_buy' => 813,
        'price_sell' => 853
    ]);

    Quote::factory()->create([
        'dollar_id' => 2,
        'price_buy' => 1055,
        'price_sell' => 1075
    ]);

    Quote::factory()->create([
        'dollar_id' => 3,
        'price_buy' => 1086,
        'price_sell' => 1097
    ]);

    Quote::factory()->create([
        'dollar_id' => 4,
        'price_buy' => 0,
        'price_sell' => 1365
    ]);
});


it('can see the list of currencies page', function () {
    $this->get(AccountXCurrencyResource::getUrl())
        ->assertSuccessful()
        ->assertSee('My Currencies')
        ->assertSee('No My Currencies')
        ->assertSee('New Currency')
        ->assertSee('List');
});

it('show the currencies', function () {
    $account = Account::first();
    $accounts_x_currencies = AccountXCurrency::factory()->count(10)->create([
        'account_id' => $account
    ]);
    livewire(AccountXCurrencyResource\Pages\ListAccountXCurrencies::class)
        ->assertCanSeeTableRecords($accounts_x_currencies);
});

it('can see the create of accounts_x_currencies page', function () {
    $this->get(AccountXCurrencyResource::getUrl('create'))
        ->assertSuccessful()
        ->assertSee('New Currency')
        ->assertSee('Account')
        ->assertSee('Currency')
        ->assertSee('Amount')
        ->assertSee('Create')
        ->assertSee('Create & create another')
        ->assertSee('Cancel');
});

it('can create an accounts_x_currencies', function () {
    $account_x_currency = AccountXCurrency::factory()->make();

    livewire(AccountXCurrencyResource\Pages\CreateAccountXCurrency::class)
        ->fillForm([
            'account_id' => $account_x_currency->account_id,
            'currency_id' => $account_x_currency->currency_id,
            'amount' => $account_x_currency->amount,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(AccountXCurrency::class, [
        'account_id' => $account_x_currency->account_id,
        'currency_id' => $account_x_currency->currency_id,
        'amount' => $account_x_currency->amount,
    ]);
});

it('can create an account_x_currencies and create another', function () {
    $account_x_currency = AccountXCurrency::factory()->make();

    livewire(AccountXCurrencyResource\Pages\CreateAccountXCurrency::class)
        ->fillForm([
            'account_id' => $account_x_currency->account_id,
            'currency_id' => $account_x_currency->currency_id,
            'amount' => $account_x_currency->amount,
        ])
        ->call('createAnother')
        ->assertHasNoFormErrors()
        ->assertSee('New Currency')
        ->assertSee('Account')
        ->assertSee('Currency')
        ->assertSee('Amount')
        ->assertSee('Create')
        ->assertSee('Create & create another')
        ->assertSee('Cancel');

    $this->assertDatabaseHas(AccountXCurrency::class, [
        'account_id' => $account_x_currency->account_id,
        'currency_id' => $account_x_currency->currency_id,
        'amount' => $account_x_currency->amount,
    ]);
});

it('can see the edit of accounts_x_currencies page', function () {
    $account_x_currency = AccountXCurrency::factory()->create();
    $this->get(AccountXCurrencyResource::getUrl('edit', ['record' => $account_x_currency]))
        ->assertSuccessful()
        ->assertSee('Edit Currency')
        ->assertSee('Account')
        ->assertSee('Currency')
        ->assertSee('Amount')
        ->assertSee('Save changes')
        ->assertSee('Cancel');
});

it('can fill data in the edit of accounts_x_currencies page', function () {
    $account_x_currency = AccountXCurrency::factory()->create();

    livewire(AccountXCurrencyResource\Pages\EditAccountXCurrency::class, [
        'record' => $account_x_currency->getRouteKey(),
    ])
        ->assertFormSet([
            'account_id' => $account_x_currency->account_id,
            'currency_id' => $account_x_currency->currency_id,
            'amount' => $account_x_currency->amount,
        ]);
});

it('can update data in the edit of accounts page', function () {
    $account_x_currency = AccountXCurrency::factory()->create();
    $newData = AccountXCurrency::factory()->make();

    livewire(AccountXCurrencyResource\Pages\EditAccountXCurrency::class, [
        'record' => $account_x_currency->getRouteKey(),
    ])
        ->fillForm([
            'account_id' => $newData->account_id,
            'currency_id' => $newData->currency_id,
            'amount' => $newData->amount,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($account_x_currency->refresh())
        ->account_id->toBe($newData->account_id)
        ->currency_id->toBe($newData->currency_id)
        ->amount->toBe($newData->amount);
});

it('account is a required select', function () {
    $account_x_currency = AccountXCurrency::factory()->create();

    livewire(AccountXCurrencyResource\Pages\EditAccountXCurrency::class, [
        'record' => $account_x_currency->getRouteKey(),
    ])
        ->fillForm([
            'account_id' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['account_id' => 'required']);
});

it('currency is a required select', function () {
    $account_x_currency = AccountXCurrency::factory()->create();

    livewire(AccountXCurrencyResource\Pages\EditAccountXCurrency::class, [
        'record' => $account_x_currency->getRouteKey(),
    ])
        ->fillForm([
            'currency_id' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['currency_id' => 'required']);
});

it('amount is a required input', function () {
    $account_x_currency = AccountXCurrency::factory()->create();

    livewire(AccountXCurrencyResource\Pages\EditAccountXCurrency::class, [
        'record' => $account_x_currency->getRouteKey(),
    ])
        ->fillForm([
            'amount' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['amount' => 'required']);
});


it('can edit from list page', function () {
    $account_x_currency = AccountXCurrency::factory()->create();
    livewire(AccountXCurrencyResource\Pages\ListAccountXCurrencies::class)
        ->assertTableActionEnabled(EditAction::class, $account_x_currency);
});

it('can not see delete from edit page', function () {
    $account_x_currency = AccountXCurrency::factory()->create();
    livewire(AccountXCurrencyResource\Pages\EditAccountXCurrency::class, [
        'record' => $account_x_currency->getRouteKey(),
    ])->assertActionDoesNotExist(DeleteAction::class);
});

it('can see the delete from list page', function () {
    $account_x_currency = AccountXCurrency::factory()->create();
    livewire(AccountXCurrencyResource\Pages\ListAccountXCurrencies::class)
        ->assertTableBulkActionEnabled(DeleteAction::class)
        ->assertTableActionEnabled(DeleteAction::class, $account_x_currency);
});

it('can delete from the list', function () {
    $account_x_currency = AccountXCurrency::factory()->create();

    livewire(AccountXCurrencyResource\Pages\ListAccountXCurrencies::class, [
        'record' => $account_x_currency->getRouteKey(),
    ])->callTableAction(DeleteAction::class, $account_x_currency);

    $this->assertModelMissing($account_x_currency);
});

it('can delete from bulk actions', function () {
    $account_x_currency = AccountXCurrency::factory()->create();

    livewire(AccountXCurrencyResource\Pages\ListAccountXCurrencies::class, [
        'record' => $account_x_currency->getRouteKey(),
    ])->callTableBulkAction(DeleteAction::class, [$account_x_currency]);

    $this->assertModelMissing($account_x_currency);
});

