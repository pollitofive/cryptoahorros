<?php

namespace Tests\Feature;

use App\Filament\Resources\AccountXCoinResource;
use App\Models\Account;
use App\Models\AccountXCoin;
use App\Models\Coin;
use App\Models\Currency;
use App\Models\Dollar;
use App\Models\Market;
use App\Models\Quote;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Illuminate\Support\Facades\DB;
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

    $account = Account::first();
    $coins = Coin::factory()->count(10)->create();
    foreach ($coins as $coin) {
        AccountXCoin::factory()->create([
            'account_id' => $account,
            'coin_id' => $coin
        ]);

        Market::factory()->create([
            'coin_id' => $coin->id,
        ]);
    }

});


it('can see the list of coins page', function () {

    DB::table('accounts_x_coins')->delete();

    $this->get(AccountXCoinResource::getUrl())
        ->assertSuccessful()
        ->assertSee('My Coins')
        ->assertSee('No My Coins')
        ->assertSee('New Coin')
        ->assertSee('List');
});

it('show the coins', function () {
    $accounts_x_coins = AccountXCoin::all();
    livewire(AccountXCoinResource\Pages\ListAccountXCoin::class)
        ->assertCanSeeTableRecords($accounts_x_coins);

    $response = $this->get(AccountXCoinResource::getUrl());
    $response->assertSee('Current price');
    $response->assertSee('Total by coin');
    $response->assertSee('Summary');
    $response->assertSee('Sum total of coins');
    $response->assertSee("USD " . number_format(Coin::getSumAmountByPriceOfCoin(),2));

    foreach ($accounts_x_coins as $account_x_coin) {
        $response->assertSee('USD ' . number_format($account_x_coin->coin->current_price,2))
            ->assertSee('USD ' . number_format($account_x_coin->amount * $account_x_coin->coin->markets->first()->current_price,2));

    }
});

it('can see the create of accounts_x_coin page', function () {
    $this->get(AccountXCoinResource::getUrl('create'))
        ->assertSuccessful()
        ->assertSee('New Coin')
        ->assertSee('Account')
        ->assertSee('Coin')
        ->assertSee('Amount')
        ->assertSee('Create')
        ->assertSee('Create & create another')
        ->assertSee('Cancel');
});

it('can create an accounts_x_coin', function () {
    $account_x_coin = AccountXCoin::factory()->make();

    livewire(AccountXCoinResource\Pages\CreateAccountXCoin::class)
        ->fillForm([
            'account_id' => $account_x_coin->account_id,
            'coin_id' => $account_x_coin->coin_id,
            'amount' => $account_x_coin->amount,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(AccountXCoin::class, [
        'account_id' => $account_x_coin->account_id,
        'coin_id' => $account_x_coin->coin_id,
        'amount' => $account_x_coin->amount,
    ]);
});

it('can create an account_x_coin and create another', function () {
    $account_x_coin = AccountXCoin::factory()->make();

    livewire(AccountXCoinResource\Pages\CreateAccountXCoin::class)
        ->fillForm([
            'account_id' => $account_x_coin->account_id,
            'coin_id' => $account_x_coin->coin_id,
            'amount' => $account_x_coin->amount,
        ])
        ->call('createAnother')
        ->assertHasNoFormErrors()
        ->assertSee('New Coin')
        ->assertSee('Account')
        ->assertSee('Coin')
        ->assertSee('Amount')
        ->assertSee('Create')
        ->assertSee('Create & create another')
        ->assertSee('Cancel');

    $this->assertDatabaseHas(AccountXCoin::class, [
        'account_id' => $account_x_coin->account_id,
        'coin_id' => $account_x_coin->coin_id,
        'amount' => $account_x_coin->amount,
    ]);
});

it('can see the edit of accounts_x_coin page', function () {
    $account_x_coin = AccountXCoin::factory()->create();
    $this->get(AccountXCoinResource::getUrl('edit', ['record' => $account_x_coin]))
        ->assertSuccessful()
        ->assertSee('Edit Coin')
        ->assertSee('Account')
        ->assertSee('Coin')
        ->assertSee('Amount')
        ->assertSee('Save changes')
        ->assertSee('Cancel');
});

it('can fill data in the edit of accounts_x_coin page', function () {
    $account_x_coin = AccountXCoin::factory()->create();

    livewire(AccountXCoinResource\Pages\EditAccountXCoin::class, [
        'record' => $account_x_coin->getRouteKey(),
    ])
        ->assertFormSet([
            'account_id' => $account_x_coin->account_id,
            'coin_id' => $account_x_coin->coin_id,
            'amount' => $account_x_coin->amount,
        ]);
});

it('can update data in the edit of coins page', function () {
    $account_x_coin = AccountXCoin::factory()->create();
    $newData = AccountXCoin::factory()->make();

    livewire(AccountXCoinResource\Pages\EditAccountXCoin::class, [
        'record' => $account_x_coin->getRouteKey(),
    ])
        ->fillForm([
            'account_id' => $newData->account_id,
            'coin_id' => $newData->coin_id,
            'amount' => $newData->amount,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($account_x_coin->refresh())
        ->account_id->toBe($newData->account_id)
        ->coin_id->toBe($newData->coin_id)
        ->amount->toBe($newData->amount);
});

it('account is a required select', function () {
    $account_x_coin = AccountXCoin::factory()->create();

    livewire(AccountXCoinResource\Pages\EditAccountXCoin::class, [
        'record' => $account_x_coin->getRouteKey(),
    ])
        ->fillForm([
            'account_id' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['account_id' => 'required']);
});

it('coin is a required select', function () {
    $account_x_coin = AccountXCoin::factory()->create();

    livewire(AccountXCoinResource\Pages\EditAccountXCoin::class, [
        'record' => $account_x_coin->getRouteKey(),
    ])
        ->fillForm([
            'coin_id' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['coin_id' => 'required']);
});

it('amount is a required input', function () {
    $account_x_coin = AccountXCoin::factory()->create();

    livewire(AccountXCoinResource\Pages\EditAccountXCoin::class, [
        'record' => $account_x_coin->getRouteKey(),
    ])
        ->fillForm([
            'amount' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['amount' => 'required']);
});


it('can edit from list page', function () {
    $account_x_coin = AccountXCoin::factory()->create();
    livewire(AccountXCoinResource\Pages\ListAccountXCoin::class)
        ->assertTableActionEnabled(EditAction::class, $account_x_coin);
});

it('can not see delete from edit page', function () {
    $account_x_coin = AccountXCoin::factory()->create();
    livewire(AccountXCoinResource\Pages\EditAccountXCoin::class, [
        'record' => $account_x_coin->getRouteKey(),
    ])->assertActionDoesNotExist(DeleteAction::class);
});

it('can see the delete from list page', function () {
    $account_x_coin = AccountXCoin::factory()->create();
    livewire(AccountXCoinResource\Pages\ListAccountXCoin::class)
        ->assertTableBulkActionEnabled(DeleteAction::class)
        ->assertTableActionEnabled(DeleteAction::class, $account_x_coin);
});

it('can delete from the list', function () {
    $account_x_coin = AccountXCoin::factory()->create();

    livewire(AccountXCoinResource\Pages\ListAccountXCoin::class, [
        'record' => $account_x_coin->getRouteKey(),
    ])->callTableAction(DeleteAction::class, $account_x_coin);

    $this->assertModelMissing($account_x_coin);
});

it('can delete from bulk actions', function () {
    $account_x_coin = AccountXCoin::factory()->create();

    livewire(AccountXCoinResource\Pages\ListAccountXCoin::class, [
        'record' => $account_x_coin->getRouteKey(),
    ])->callTableBulkAction(DeleteAction::class, [$account_x_coin]);

    $this->assertModelMissing($account_x_coin);
});
