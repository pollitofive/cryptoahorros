<?php

namespace Tests\Feature;

it('the url register works', function () {
    $this->get('/register')
        ->assertOk()
        ->assertSee('Register')
        ->assertSee('Coinsavings')
        ->assertSee('Sign up')
        ->assertSee('sign in to your account')
        ->assertSee('Username')
        ->assertSee('Name')
        ->assertSee('Password')
        ->assertSee('Confirm password');
});

it('the register works', function () {
    $this->get('/register',[
        'username' => 'test',
        'name' => 'test',
        'password' => 'testtest',
        'password_confirmation' => 'testtest'
    ])->assertOk();
});
