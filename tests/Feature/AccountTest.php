<?php

namespace Tests\Feature;

use App\Filament\Resources\AccountResource;
use App\Models\Account;
use App\Models\User;
use function Pest\Livewire\livewire;

beforeEach(function(){
    $this->actingAs(User::factory()->create());
});


it('can see the list of accounts page', function () {
    $this->get(AccountResource::getUrl('index'))
        ->assertSuccessful()
        ->assertSee('My Accounts')
        ->assertSee('No My Accounts')
        ->assertSee('New Account')
        ->assertSee('List');
});

it('show the accounts', function () {
    $accounts = Account::factory()->count(10)->create([
        'user_id' => auth()->id()
    ]);

    livewire(AccountResource\Pages\ListAccounts::class)
        ->assertCanSeeTableRecords($accounts);
});

it('can see the create of accounts page', function () {
    $this->get(AccountResource::getUrl('create'))
        ->assertSuccessful()
        ->assertSee('New Account')
        ->assertSee('Name')
        ->assertSee('Url')
        ->assertSee('Create')
        ->assertSee('Create & create another')
        ->assertSee('Cancel')
    ;
});

it('can create an account', function () {
    $newData = Account::factory()->make();

    livewire(AccountResource\Pages\CreateAccount::class)
        ->fillForm([
            'name' => $newData->name,
            'url' => $newData->url,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Account::class, [
        'name' => $newData->name,
        'url' => $newData->url
    ]);
});
