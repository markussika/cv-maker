<?php

namespace Tests\Feature;

use App\Models\Cv;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CvManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_form_does_not_prefill_existing_cv(): void
    {
        $user = User::factory()->create();
        Cv::factory()->for($user)->create([
            'first_name' => 'Existing',
            'last_name' => 'Person',
        ]);

        $response = $this->actingAs($user)->get(route('cv.create'));

        $response->assertOk();
        $response->assertViewHas('prefill', null);
        $response->assertDontSee('Existing');
    }

    public function test_history_page_lists_only_authenticated_users_cvs(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $firstCv = Cv::factory()->for($user)->create([
            'first_name' => 'Alice',
            'last_name' => 'Writer',
        ]);

        $secondCv = Cv::factory()->for($user)->create([
            'first_name' => 'Bob',
            'last_name' => 'Designer',
        ]);

        Cv::factory()->for($otherUser)->create([
            'first_name' => 'Charlie',
            'last_name' => 'Other',
        ]);

        $response = $this->actingAs($user)->get(route('cv.history'));

        $response->assertOk();
        $response->assertSee('Alice Writer', false);
        $response->assertSee('Bob Designer', false);
        $response->assertDontSee('Charlie Other');
    }

    public function test_user_can_update_cv(): void
    {
        $user = User::factory()->create();
        $cv = Cv::factory()->for($user)->create([
            'first_name' => 'Initial',
            'template' => 'classic',
        ]);

        $payload = [
            'first_name' => 'Updated',
            'last_name' => 'Candidate',
            'email' => 'updated@example.com',
            'phone' => '123456789',
            'birthday' => '1990-01-01',
            'country' => 'France',
            'city' => 'Paris',
            'template' => 'modern',
            'education' => [
                [
                    'institution' => 'Updated University',
                    'degree' => 'MBA',
                    'field' => 'Management',
                    'country' => 'France',
                    'city' => 'Paris',
                    'start_year' => '2012',
                    'end_year' => '2014',
                ],
            ],
            'experience' => [
                [
                    'position' => 'Lead',
                    'company' => 'Acme Corp',
                    'country' => 'France',
                    'city' => 'Paris',
                    'from' => '2015-01',
                    'to' => '2019-01',
                    'currently' => false,
                    'achievements' => 'Improved processes.',
                ],
            ],
            'hobbies' => ['Cycling', 'Painting'],
        ];

        $response = $this->actingAs($user)->put(route('cv.update', $cv), $payload);

        $response->assertRedirect(route('cv.preview'));
        $response->assertSessionHas('status', __('Your CV has been updated.'));

        $cv->refresh();

        $this->assertEquals('Updated', $cv->first_name);
        $this->assertEquals('modern', $cv->template);
        $this->assertEquals(['Cycling', 'Painting'], $cv->hobbies);
        $this->assertEquals('updated@example.com', $cv->email);
        $this->assertSame('Paris', $cv->city);

        $this->assertEquals('Updated', session('cv_data.first_name'));
    }

    public function test_user_can_delete_cv(): void
    {
        $user = User::factory()->create();
        $cv = Cv::factory()->for($user)->create();

        $response = $this->actingAs($user)
            ->withSession(['cv_data' => ['id' => $cv->id]])
            ->delete(route('cv.destroy', $cv));

        $response->assertRedirect(route('cv.history'));
        $response->assertSessionHas('status', __('The CV has been deleted.'));
        $response->assertSessionMissing('cv_data');

        $this->assertDatabaseMissing('cvs', ['id' => $cv->id]);
    }

    public function test_user_cannot_manage_another_users_cv(): void
    {
        $user = User::factory()->create();
        $otherCv = Cv::factory()->for(User::factory())->create();

        $this->actingAs($user)
            ->get(route('cv.edit', $otherCv))
            ->assertForbidden();

        $this->actingAs($user)
            ->put(route('cv.update', $otherCv), [])
            ->assertForbidden();

        $this->actingAs($user)
            ->delete(route('cv.destroy', $otherCv))
            ->assertForbidden();
    }
}
