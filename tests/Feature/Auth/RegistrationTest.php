<?php

use Livewire\Volt\Volt;

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = Volt::test('auth.register')
        ->set('name', 'Test User')
        ->set('email', 'user@uom.lk')
        ->set('batch', '20')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->set('contact', '762225674')
        ->call('register');

    $response
        ->assertHasNoErrors()
        ->assertRedirect(route('verification.notice', absolute: false));

    $this->assertAuthenticated();
});

test('registration requires uom.lk email domain', function () {
    $response = Volt::test('auth.register')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('batch', '20')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->set('contact', '762225674')
        ->call('register');

    $response->assertHasErrors('email');
    $this->assertGuest();
});