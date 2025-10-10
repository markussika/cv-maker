<?php

use App\Models\Cv;
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

it('renders the CV creation form with expected content', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('cv.create'));

    $response
        ->assertOk()
        ->assertSeeText('Craft your CV')
        ->assertSeeText('Save & preview')
        ->assertSeeText('Canada')
        ->assertSeeText('Classic');
});

it('prefills the form when editing an existing CV', function (): void {
    $cv = Cv::factory()->create([
        'first_name' => 'Jamie',
        'last_name' => 'Doe',
        'template' => 'modern',
    ]);

    $response = $this->actingAs($cv->user)->get(route('cv.edit', $cv));

    $response
        ->assertOk()
        ->assertSeeText('Update your CV')
        ->assertSeeText('Update & preview')
        ->assertSee('value="Jamie"', false)
        ->assertSee('name="_method" value="PUT"', false);
});
