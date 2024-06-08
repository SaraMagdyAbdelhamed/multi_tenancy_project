<?php

use App\Providers\RouteServiceProvider;

test('registration screen can be rendered', function () {
    $response = $this->get('/member/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/member/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

     // Check if the user is successfully registered
     $response->assertStatus(302); // Check for a redirect response
    // Check if the user is authenticated using the "member" guard
    $this->assertTrue(Auth::guard('member')->check());
    $response->assertRedirect(RouteServiceProvider::HOME);
});
