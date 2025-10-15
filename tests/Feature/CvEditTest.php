<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Cv;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('īpašnieks var atvērt edit formu savam CV', function () {
    $owner = User::factory()->create();

    /** @var Cv $cv */
    $cv = Cv::factory()->create([
        'user_id'    => $owner->id,
        'first_name' => 'John',
        'last_name'  => 'Doe',
        'email'      => 'john@example.com',
        'template'   => 'classic',
    ]);

    $this->actingAs($owner)
        ->get(route('cv.edit', $cv))
        ->assertOk()
        ->assertSee('Rediģēt', escape: false); // Pielāgo pēc savas lapas teksta
});

it('īpašnieks var atjaunināt savu CV', function () {
    $owner = User::factory()->create();

    /** @var Cv $cv */
    $cv = Cv::factory()->create([
        'user_id'    => $owner->id,
        'first_name' => 'John',
        'last_name'  => 'Doe',
        'email'      => 'john@example.com',
        'template'   => 'classic',
    ]);

    $payload = [
        'first_name' => 'Johnny',
        'last_name'  => 'Doe',
        'email'      => 'johnny@example.com',
        'phone'      => '+371 20000000',
        'summary'    => 'Jauns kopsavilkums',
        'template'   => 'modern',
    ];

    $this->actingAs($owner)
        ->put(route('cv.update', $cv), $payload)
        ->assertRedirect(route('cv.edit', $cv)); // pēc update redirect uz edit (pielāgo, ja cits maršruts)

    $this->assertDatabaseHas('cvs', [
        'id'         => $cv->id,
        'user_id'    => $owner->id,
        'first_name' => 'Johnny',
        'email'      => 'johnny@example.com',
        'template'   => 'modern',
    ]);
});

it('cits lietotājs nevar rediģēt svešu CV (403)', function () {
    $owner = User::factory()->create();
    $attacker = User::factory()->create();

    /** @var Cv $cv */
    $cv = Cv::factory()->create([
        'user_id'    => $owner->id,
        'first_name' => 'Alice',
        'last_name'  => 'Smith',
        'email'      => 'alice@example.com',
        'template'   => 'classic',
    ]);

    // mēģina atvērt edit formu
    $this->actingAs($attacker)
        ->get(route('cv.edit', $cv))
        ->assertForbidden();

    // mēģina veikt update
    $this->put(route('cv.update', $cv), [
        'first_name' => 'Hacked',
        'last_name'  => 'User',
        'email'      => 'hacked@example.com',
        'template'   => 'modern',
    ])->assertForbidden();

    // pārliecināmies, ka DB nav izmaiņu
    $this->assertDatabaseHas('cvs', [
        'id'         => $cv->id,
        'first_name' => 'Alice',
        'email'      => 'alice@example.com',
        'template'   => 'classic',
    ]);
});
