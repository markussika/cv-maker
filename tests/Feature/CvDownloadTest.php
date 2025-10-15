<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Testing\TestResponse;

uses(RefreshDatabase::class);

/**
 * Palīgfunkcija: mēģina atrast maršruta NAME, pretējā gadījumā izmanto PATH,
 * un, ja vajag parametru (piem., {cv} vai {id}), iedod to.
 */
function hitGet(string $routeName, string $fallbackPath, array $params = []): TestResponse {
    if (Route::has($routeName)) {
        // Ja maršrutam vajag parametrus, padodam tos
        return test()->get(route($routeName, $params));
    }
    // Pretējā gadījumā – tiešais ceļš (ar iespējamu id pielikumu)
    if (!empty($params)) {
        // mēģinām {id} beigās
        $id = reset($params);
        $path = rtrim($fallbackPath, '/').'/'.$id;
        return test()->get($path);
    }
    return test()->get($fallbackPath);
}

function hitPost(string $routeName, string $fallbackPath, array $payload): TestResponse {
    if (Route::has($routeName)) {
        return test()->post(route($routeName), $payload);
    }
    return test()->post($fallbackPath, $payload);
}

it('izveido CV un ļauj to lejupielādēt kā PDF', function () {
    $user = User::factory()->create();

    // Minimālais payloads — PIELĀGO, ja validācija prasa vairāk laukus
    $payload = [
        'first_name' => 'John',
        'last_name'  => 'Doe',
        'email'      => 'john.doe@example.com',
        'template'   => 'classic',
    ];

    // 1) CREATE (store)
    // mēģinām pēc route name -> citādi POST uz /cv/store vai /cv
    $this->actingAs($user);

    $create = hitPost('cv.store', '/cv/store', $payload);

    // Dažos projektos notiek redirect uz preview; dažos – 200 OK ar skatu.
    // Pieņemam jebkuru no šiem, bet obligāti bez kļūdām.
    $create->assertStatus(in_array($create->getStatusCode(), [200, 302]) ? $create->getStatusCode() : 200);

    // Ja DB ir tabula ar CV (nosaukums var būt 'cvs', 'resumes' u.tml.),
    // atkomentē atbilstošo rindu un PIELĀGO tabulas nosaukumu/laukus:
    $this->assertDatabaseHas('cvs', [
        'user_id'    => $user->id,
        'first_name' => 'John',
        'last_name'  => 'Doe',
        'template'   => 'classic',
    ]);

    // Ja lejupielādei vajag ID, paņemam to no jaunākā ieraksta (pielāgo modeli un tabulu!)
    // Piemērs: App\Models\Cv vai App\Models\Resume
    $cvId = null;
    if (class_exists(\App\Models\Cv::class)) {
        $cvId = \App\Models\Cv::query()->latest('id')->value('id');
    } elseif (class_exists(\App\Models\Resume::class)) {
        $cvId = \App\Models\Resume::query()->latest('id')->value('id');
    }

    // 2) DOWNLOAD (attachment PDF)
    // Mēģinām pēc route name -> citādi GET uz /cv/download; ja vajag ID, to pievieno.
    $params = $cvId ? ['cv' => $cvId, 'id' => $cvId] : [];
    $download = hitGet('cv.download', '/cv/download', $params);

    // Pārbaudes: 200, PDF un disposition=attachment ar faila nosaukumu
    $download->assertOk();
    $download->assertHeader('content-type', 'application/pdf');

    // Ja kontrolieris iestata 'attachment; filename=first_last_cv.pdf'
    // Pārbaudām tikai "attachment" klātbūtni — nosaukums var atšķirties.
    $disposition = $download->headers->get('content-disposition');
    expect($disposition)->toContain('attachment');
    // Ja gribi stingrāku pārbaudi:
    // expect($disposition)->toContain('john_doe_cv.pdf');
});
