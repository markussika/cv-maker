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

dataset('available templates', [
    'classic',
    'modern',
    'creative',
    'minimal',
    'elegant',
    'corporate',
    'gradient',
    'darkmode',
    'futuristic',
]);





it('displays the template gallery with preview and start links for every available design', function (string $template): void {
    $response = $this->get(route('cv.templates'));

    $response
        ->assertOk()
        ->assertSee(route('cv.template-preview', $template), false)
        ->assertSee(route('cv.create', ['template' => $template]), false);
})->with('available templates');

it('returns a not found response when previewing an unavailable template', function (): void {
    $this->get(route('cv.template-preview', ['template' => 'nonexistent-template']))
        ->assertNotFound();
});