<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;


test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();
    
    $response = $this->post(route('admin.login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);
    $this->actingAs($user,'web');
    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
    
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post(route('admin.login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
