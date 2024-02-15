<?php

namespace Tests\Feature;

use App\Models\User;

it('the url login works', function () {
    $this->get('/login')
        ->assertOk()
        ->assertSee('Login')
        ->assertSee('Coinsavings')
        ->assertSee('Sign in')
        ->assertSee('sign up for an account')
        ->assertSee('Username')
        ->assertSee('Password')
        ->assertSee('Remember me');
});

it('the login works', function () {
    $user = User::factory()->create();
    test()->actingAs($user)->get('/')->assertOk();
});
