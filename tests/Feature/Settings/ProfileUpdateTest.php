<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Volt;

test('profile page is displayed', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->get(route('settings.profile'))->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Volt::test('settings.profile')
        ->set('name', 'Test User')
        ->set('contact', '771234567')
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    $user->refresh();

    expect($user->name)->toEqual('Test User');
    expect($user->contact)->toEqual('771234567');
});

test('contact number can be updated with valid format', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Volt::test('settings.profile')
        ->set('name', $user->name)
        ->set('contact', '771234567')
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    expect($user->refresh()->contact)->toEqual('771234567');
});

test('contact number validation rejects invalid formats', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    // Test invalid formats
    foreach (['012345678', '77123456', '7712345678', 'abc123456'] as $invalidContact) {
        $response = Volt::test('settings.profile')
            ->set('name', $user->name)
            ->set('contact', $invalidContact)
            ->call('updateProfileInformation');

        $response->assertHasErrors(['contact']);
    }
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Volt::test('settings.delete-user-form')
        ->set('password', 'password')
        ->call('deleteUser');

    $response
        ->assertHasNoErrors()
        ->assertRedirect('/');

    expect($user->fresh())->toBeNull();
    expect(Auth::check())->toBeFalse();
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Volt::test('settings.delete-user-form')
        ->set('password', 'wrong-password')
        ->call('deleteUser');

    $response->assertHasErrors(['password']);

    expect($user->fresh())->not->toBeNull();
});