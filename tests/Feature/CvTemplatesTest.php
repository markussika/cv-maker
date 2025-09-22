<?php

use App\Models\User;

it('renders the CV templates page for authenticated users', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/cv/templates');

    $response->assertOk();
    $response->assertViewIs('templates.index');
});
