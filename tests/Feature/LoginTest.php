<?php 

use App\Models\User;

it('may sign in the user', function () {
    // Event::fake();
 
    User::factory()->create([ // assumes RefreshDatabase trait is used on Pest.php...
        'email' => 'avery@example.com',
        'password' => 'password',
    ]);
 
    $page = visit('/');
 
    $page->click('Login')
         
         
         ->fill('email', 'avery@example.com')
         ->fill('password', 'password')
         ->click('Log in')
         ->assertSee('Dashboard');
 
    $this->assertAuthenticated();
 
    //Event::assertDispatched(UserLoggedIn::class);
});