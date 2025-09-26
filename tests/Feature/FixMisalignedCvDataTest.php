<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class FixMisalignedCvDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_migration_realigns_shifted_cv_rows(): void
    {
        $user = User::factory()->create();

        $profileImage = 'avatars/ada.png';
        $hobbies = ['Reading', 'Mathematics'];
        $languages = [
            ['name' => 'English', 'level' => 'Native'],
        ];
        $experience = [
            [
                'position' => 'Analyst',
                'company' => 'Difference Engine',
                'country' => 'United Kingdom',
                'city' => 'London',
                'from' => '1842-01',
                'to' => '1843-12',
                'currently' => false,
                'achievements' => 'Translated Bernoulli article.',
            ],
        ];
        $education = [
            [
                'institution' => 'Royal Society',
                'degree' => 'Countess',
                'field' => 'Mathematics',
                'country' => 'United Kingdom',
                'city' => 'London',
                'start_year' => '1830',
                'end_year' => '1832',
            ],
        ];
        $skills = ['Mathematics', 'Poetry'];
        $activities = ['Translation', 'Lecturing'];
        $createdAt = Carbon::parse('2024-09-01 10:20:30');
        $updatedAt = Carbon::parse('2024-09-22 08:15:45');

        DB::table('cvs')->insert([
            'user_id' => $user->id,
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'email' => 'ada@example.com',
            'phone' => '123456789',
            'headline' => $profileImage,
            'summary' => json_encode($hobbies),
            'website' => json_encode($languages),
            'linkedin' => json_encode($experience),
            'github' => json_encode($education),
            'birthday' => json_encode($skills),
            'country' => json_encode($activities),
            'city' => $createdAt->toDateTimeString(),
            'template' => $updatedAt->toDateTimeString(),
            'profile_image' => null,
            'hobbies' => null,
            'languages' => null,
            'work_experience' => null,
            'education' => null,
            'skills' => null,
            'extra_curriculum_activities' => null,
            'created_at' => Carbon::parse('1999-01-01 00:00:00')->toDateTimeString(),
            'updated_at' => Carbon::parse('1999-01-02 00:00:00')->toDateTimeString(),
        ]);

        $alignedCreatedAt = Carbon::parse('2024-08-01 12:00:00');
        $alignedUpdatedAt = Carbon::parse('2024-08-02 12:00:00');

        DB::table('cvs')->insert([
            'user_id' => User::factory()->create()->id,
            'first_name' => 'Grace',
            'last_name' => 'Hopper',
            'email' => 'grace@example.com',
            'phone' => '555-0000',
            'headline' => 'Pioneer Computer Scientist',
            'summary' => 'Invented the first compiler.',
            'website' => 'https://grace.example.com',
            'linkedin' => 'https://linkedin.com/in/grace',
            'github' => 'https://github.com/grace',
            'birthday' => '1906-12-09',
            'country' => 'United States',
            'city' => 'New York',
            'template' => 'modern',
            'profile_image' => 'avatars/grace.png',
            'hobbies' => json_encode(['Sailing']),
            'languages' => json_encode([
                ['name' => 'English', 'level' => 'Native'],
            ]),
            'work_experience' => json_encode([
                [
                    'position' => 'Rear Admiral',
                    'company' => 'US Navy',
                    'country' => 'United States',
                    'city' => 'Washington',
                    'from' => '1943-01',
                    'to' => '1986-01',
                    'currently' => false,
                    'achievements' => 'COBOL pioneer',
                ],
            ]),
            'education' => json_encode([
                [
                    'institution' => 'Yale University',
                    'degree' => 'PhD',
                    'field' => 'Mathematics',
                    'country' => 'United States',
                    'city' => 'New Haven',
                    'start_year' => '1934',
                    'end_year' => '1934',
                ],
            ]),
            'skills' => json_encode(['Leadership']),
            'extra_curriculum_activities' => json_encode(['Teaching']),
            'created_at' => $alignedCreatedAt->toDateTimeString(),
            'updated_at' => $alignedUpdatedAt->toDateTimeString(),
        ]);

        $migration = require database_path('migrations/2025_09_26_000000_fix_misaligned_cv_data.php');
        $migration->up();

        $fixed = DB::table('cvs')->where('email', 'ada@example.com')->first();

        $this->assertNotNull($fixed);
        $this->assertSame('classic', $fixed->template);
        $this->assertSame($profileImage, $fixed->profile_image);
        $this->assertNull($fixed->headline);
        $this->assertNull($fixed->summary);
        $this->assertNull($fixed->website);
        $this->assertNull($fixed->linkedin);
        $this->assertNull($fixed->github);
        $this->assertNull($fixed->birthday);
        $this->assertNull($fixed->country);
        $this->assertNull($fixed->city);

        $this->assertSame($createdAt->format('Y-m-d H:i:s'), $fixed->created_at);
        $this->assertSame($updatedAt->format('Y-m-d H:i:s'), $fixed->updated_at);

        $this->assertSame($hobbies, json_decode($fixed->hobbies, true));
        $this->assertSame($languages, json_decode($fixed->languages, true));
        $this->assertSame($experience, json_decode($fixed->work_experience, true));
        $this->assertSame($education, json_decode($fixed->education, true));
        $this->assertSame($skills, json_decode($fixed->skills, true));
        $this->assertSame($activities, json_decode($fixed->extra_curriculum_activities, true));

        $aligned = DB::table('cvs')->where('email', 'grace@example.com')->first();

        $this->assertNotNull($aligned);
        $this->assertSame('modern', $aligned->template);
        $this->assertSame('Pioneer Computer Scientist', $aligned->headline);
        $this->assertSame('Invented the first compiler.', $aligned->summary);
        $this->assertSame('https://grace.example.com', $aligned->website);
        $this->assertSame('https://linkedin.com/in/grace', $aligned->linkedin);
        $this->assertSame('https://github.com/grace', $aligned->github);
        $this->assertSame('1906-12-09', $aligned->birthday);
        $this->assertSame('United States', $aligned->country);
        $this->assertSame('New York', $aligned->city);
        $this->assertSame('avatars/grace.png', $aligned->profile_image);
        $this->assertSame($alignedCreatedAt->format('Y-m-d H:i:s'), $aligned->created_at);
        $this->assertSame($alignedUpdatedAt->format('Y-m-d H:i:s'), $aligned->updated_at);

        $migration->up();

        $again = DB::table('cvs')->where('email', 'ada@example.com')->first();
        $this->assertSame($profileImage, $again->profile_image);
        $this->assertSame('classic', $again->template);
    }
}
