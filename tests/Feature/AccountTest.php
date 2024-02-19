<?php

namespace Tests\Feature;

use App\Filament\Resources\AccountResource;
use App\Models\Account;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
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
    $account = Account::factory()->make();

    livewire(AccountResource\Pages\CreateAccount::class)
        ->fillForm([
            'name' => $account->name,
            'url' => $account->url,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Account::class, [
        'name' => $account->name,
        'url' => $account->url
    ]);
});

it('can create an account and create another', function () {
    $account = Account::factory()->make();

    livewire(AccountResource\Pages\CreateAccount::class)
        ->fillForm([
            'name' => $account->name,
            'url' => $account->url,
        ])
        ->call('createAnother')
        ->assertHasNoFormErrors()
        ->assertSee('New Account')
        ->assertSee('Name')
        ->assertSee('Url')
        ->assertSee('Create')
        ->assertSee('Create & create another')
        ->assertSee('Cancel');

    $this->assertDatabaseHas(Account::class, [
        'name' => $account->name,
        'url' => $account->url
    ]);
});

it('can see the edit of accounts page', function () {
    $account = Account::factory()->create();
    $this->get(AccountResource::getUrl('edit', ['record' => $account]))
        ->assertSuccessful()
        ->assertSee('Edit Account')
        ->assertSee('Name')
        ->assertSee('Url')
        ->assertSee('Save changes')
        ->assertSee('Cancel');
});

it('can fill data in the edit of accounts page', function () {
    $account = Account::factory()->create();

    livewire(AccountResource\Pages\EditAccount::class, [
        'record' => $account->getRouteKey(),
    ])
        ->assertFormSet([
            'name' => $account->name,
            'url' => $account->url
        ]);
});

it('can update data in the edit of accounts page', function () {
    $account = Account::factory()->create();
    $newData = Account::factory()->make();

    livewire(AccountResource\Pages\EditAccount::class, [
        'record' => $account->getRouteKey(),
    ])
        ->fillForm([
            'name' => $newData->name,
            'url' => $newData->url
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($account->refresh())
        ->name->toBe($newData->name)
        ->url->toBe($newData->url);
});

it('name is a required input', function () {
    $account = Account::factory()->create();

    livewire(AccountResource\Pages\EditAccount::class, [
        'record' => $account->getRouteKey(),
    ])
        ->fillForm([
            'name' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['name' => 'required']);
});

it('can edit from list page', function () {
    $account = Account::factory()->create();
    livewire(AccountResource\Pages\ListAccounts::class)
        ->assertTableActionEnabled(EditAction::class, $account);
});

it('can not see delete from edit page', function () {
    $account = Account::factory()->create();
    livewire(AccountResource\Pages\EditAccount::class, [
        'record' => $account->getRouteKey(),
    ])->assertActionDoesNotExist(DeleteAction::class);
});

it('can see the delete from list page', function () {
    $account = Account::factory()->create();
    livewire(AccountResource\Pages\ListAccounts::class)
        ->assertTableBulkActionEnabled(DeleteAction::class)
        ->assertTableActionEnabled(DeleteAction::class, $account);
});

it('can delete from the list', function () {
    $account = Account::factory()->create();

    livewire(AccountResource\Pages\ListAccounts::class, [
        'record' => $account->getRouteKey(),
    ])->callTableAction(DeleteAction::class, $account);

    $this->assertModelMissing($account);
});

it('can delete from bulk actions', function () {
    $account = Account::factory()->create();

    livewire(AccountResource\Pages\ListAccounts::class, [
        'record' => $account->getRouteKey(),
    ])->callTableBulkAction(DeleteAction::class, [$account]);

    $this->assertModelMissing($account);
});
