<?php

namespace Database\Factories;

use App\Models\Cv;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cv>
 */
class CvFactory extends Factory
{
    protected $model = Cv::class;

    public function definition(): array
    {
        $templates = ['classic', 'modern', 'creative', 'minimal', 'elegant', 'corporate', 'gradient', 'darkmode', 'futuristic'];

        $startYear = $this->faker->numberBetween(2000, 2015);
        $endYear = $startYear + $this->faker->numberBetween(1, 4);
        $fromDate = $this->faker->dateTimeBetween('-6 years', '-3 years');
        $toDate = $this->faker->dateTimeBetween($fromDate, '-1 years');

        return [
            'user_id' => User::factory(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'birthday' => $this->faker->date(),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'template' => $this->faker->randomElement($templates),
            'education' => [
                [
                    'institution' => $this->faker->company() . ' University',
                    'degree' => 'BSc',
                    'field' => $this->faker->randomElement(['Computer Science', 'Business', 'Design']),
                    'country' => $this->faker->country(),
                    'city' => $this->faker->city(),
                    'start_year' => (string) $startYear,
                    'end_year' => (string) $endYear,
                ],
            ],
            'work_experience' => [
                [
                    'position' => $this->faker->jobTitle(),
                    'company' => $this->faker->company(),
                    'country' => $this->faker->country(),
                    'city' => $this->faker->city(),
                    'from' => $fromDate->format('Y-m'),
                    'to' => $toDate->format('Y-m'),
                    'currently' => false,
                    'achievements' => $this->faker->sentence(),
                ],
            ],
            'hobbies' => $this->faker->words(3),
        ];
    }
}
