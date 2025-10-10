<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    Http::fake([
        'https://countriesnow.space/api/v0.1/countries/positions' => Http::response([
            'data' => [
                ['name' => 'Canada'],
                ['name' => 'France'],
            ],
        ], 200),
    ]);
});

it('allows selecting a template from the gallery to start CV creation with that design', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('cv.create', ['template' => 'modern']));

    $response
        ->assertOk()
        ->assertSee('id="template-modern" name="template" value="modern" class="peer sr-only" checked="checked"', false);
});

it('falls back to the default template when an unknown option is requested', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('cv.create', ['template' => 'nonexistent']));

    $response
        ->assertOk()
        ->assertSee('id="template-classic" name="template" value="classic" class="peer sr-only" checked="checked"', false)
        ->assertDontSee('id="template-nonexistent" name="template" value="nonexistent" class="peer sr-only" checked="checked"', false);
});
