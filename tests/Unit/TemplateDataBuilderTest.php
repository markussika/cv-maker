<?php

namespace Tests\Unit;

use App\View\TemplateDataBuilder;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TemplateDataBuilderTest extends TestCase
{
    public function test_it_base64_encodes_profile_image_from_public_disk(): void
    {
        Storage::fake('public');

        $imageContents = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/wIAAgMBAp3xmwAAAABJRU5ErkJggg==');
        $this->assertNotFalse($imageContents);
        Storage::disk('public')->put('cv-photos/example.png', $imageContents);

        $data = TemplateDataBuilder::fromCv([
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'profile_image' => 'cv-photos/example.png',
        ]);

        $this->assertArrayHasKey('profile_image', $data);
        $this->assertNotNull($data['profile_image']);
        $this->assertStringStartsWith('data:image/png;base64,', $data['profile_image']);
        $this->assertStringContainsString(base64_encode($imageContents), $data['profile_image']);
    }

    public function test_it_base64_encodes_profile_image_when_absolute_public_url_provided(): void
    {
        Storage::fake('public');

        $imageContents = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/wIAAgMBAp3xmwAAAABJRU5ErkJggg==');
        $this->assertNotFalse($imageContents);
        Storage::disk('public')->put('cv-photos/example.png', $imageContents);

        $absoluteUrl = 'https://app.example/storage/cv-photos/example.png';

        $data = TemplateDataBuilder::fromCv([
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'profile_image' => $absoluteUrl,
        ]);

        $this->assertArrayHasKey('profile_image', $data);
        $this->assertNotNull($data['profile_image']);
        $this->assertStringStartsWith('data:image/png;base64,', $data['profile_image']);
        $this->assertStringContainsString(base64_encode($imageContents), $data['profile_image']);
    }
}
