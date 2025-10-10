<?php

namespace Database\Seeders;

use App\Models\Cv;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class CvsTableSeeder extends Seeder
{
    public function run(): void
    {
        $records = [
            [
                'user_email' => 'avery@example.com',
                'first_name' => 'Avery',
                'last_name' => 'Johnson',
                'email' => 'avery@example.com',
                'phone' => '+1 (512) 555-0114',
                'headline' => 'Senior Product Designer',
                'summary' => 'Human-centred designer with a passion for inclusive digital experiences. '
                    . 'I lead discovery workshops and translate insights into shipping-ready design systems.',
                'website' => 'https://avery.design',
                'linkedin' => 'https://www.linkedin.com/in/averyjohnson',
                'github' => 'https://github.com/averyjohnson',
                'birthday' => '1990-04-15',
                'country' => 'United States',
                'city' => 'Austin',
                'template' => 'modern',
                'profile_image' => 'https://avatars.dicebear.com/api/avataaars/Avery%20Johnson.svg',
                'skills' => ['Design Strategy', 'Design Systems', 'Figma', 'User Research', 'Prototyping'],
                'languages' => [
                    ['name' => 'English', 'level' => 'Native'],
                    ['name' => 'Spanish', 'level' => 'Conversational'],
                ],
                'work_experience' => [
                    [
                        'position' => 'Lead Product Designer',
                        'company' => 'Brightwave Labs',
                        'country' => 'United States',
                        'city' => 'Austin',
                        'from' => '2019-05',
                        'to' => '2024-08',
                        'currently' => false,
                        'achievements' => 'Led a cross-functional squad that launched a self-service onboarding flow used by '
                            . '80k+ customers.',
                    ],
                    [
                        'position' => 'Product Designer',
                        'company' => 'Northstar SaaS',
                        'country' => 'United States',
                        'city' => 'Remote',
                        'from' => '2016-02',
                        'to' => '2019-04',
                        'currently' => false,
                        'achievements' => 'Created the design language for analytics dashboards resulting in a 23% increase '
                            . 'in activation.',
                    ],
                ],
                'education' => [
                    [
                        'institution' => 'University of Texas at Austin',
                        'degree' => 'BFA',
                        'field' => 'Interaction Design',
                        'country' => 'United States',
                        'city' => 'Austin',
                        'start_year' => '2008',
                        'end_year' => '2012',
                    ],
                ],
                'hobbies' => ['Cycling', 'Analogue Photography', 'Community Volunteering'],
                'extra_curriculum_activities' => ['Organiser, Austin UX Meetup', 'Mentor, ADPList'],
            ],
            [
                'user_email' => 'bianca@example.com',
                'first_name' => 'Bianca',
                'last_name' => 'Singh',
                'email' => 'bianca@example.com',
                'phone' => '+44 20 7946 0820',
                'headline' => 'Full Stack Software Engineer',
                'summary' => 'Polyglot engineer specialising in scalable web applications. '
                    . 'I enjoy pairing, clean architecture and mentoring early-career developers.',
                'website' => 'https://biancasingh.dev',
                'linkedin' => 'https://www.linkedin.com/in/bianca-singh',
                'github' => 'https://github.com/biancasingh',
                'birthday' => '1988-11-03',
                'country' => 'United Kingdom',
                'city' => 'London',
                'template' => 'classic',
                'profile_image' => 'https://avatars.dicebear.com/api/avataaars/Bianca%20Singh.svg',
                'skills' => ['Laravel', 'Vue.js', 'TypeScript', 'Domain-Driven Design', 'CI/CD'],
                'languages' => [
                    ['name' => 'English', 'level' => 'Native'],
                    ['name' => 'Hindi', 'level' => 'Fluent'],
                    ['name' => 'French', 'level' => 'Intermediate'],
                ],
                'work_experience' => [
                    [
                        'position' => 'Senior Software Engineer',
                        'company' => 'Nimbus Cloud',
                        'country' => 'United Kingdom',
                        'city' => 'London',
                        'from' => '2020-01',
                        'to' => '2024-09',
                        'currently' => false,
                        'achievements' => 'Architected a multi-tenant platform processing 12M events/day '
                            . 'with 99.99% uptime.',
                    ],
                    [
                        'position' => 'Software Engineer',
                        'company' => 'Helios Digital',
                        'country' => 'Germany',
                        'city' => 'Berlin',
                        'from' => '2016-07',
                        'to' => '2019-12',
                        'currently' => false,
                        'achievements' => 'Introduced automated testing and deployment pipelines '
                            . 'reducing release time by 70%.',
                    ],
                ],
                'education' => [
                    [
                        'institution' => 'Imperial College London',
                        'degree' => 'MEng',
                        'field' => 'Software Engineering',
                        'country' => 'United Kingdom',
                        'city' => 'London',
                        'start_year' => '2006',
                        'end_year' => '2010',
                    ],
                ],
                'hobbies' => ['Bouldering', 'Synth Music Production', 'Travel Blogging'],
                'extra_curriculum_activities' => ['Lead, Women Who Code London', 'Speaker, JSConf EU'],
            ],
            [
                'user_email' => 'carlos@example.com',
                'first_name' => 'Carlos',
                'last_name' => 'Mendes',
                'email' => 'carlos@example.com',
                'phone' => '+55 (11) 5555-0199',
                'headline' => 'Data Scientist & ML Engineer',
                'summary' => 'Data storyteller focused on delivering production-grade machine learning solutions. '
                    . 'Experienced in recommendation systems and MLOps.',
                'website' => 'https://carlosmendes.ai',
                'linkedin' => 'https://www.linkedin.com/in/carlos-mendes',
                'github' => 'https://github.com/carlosmendes',
                'birthday' => '1992-06-28',
                'country' => 'Brazil',
                'city' => 'São Paulo',
                'template' => 'futuristic',
                'profile_image' => 'https://avatars.dicebear.com/api/avataaars/Carlos%20Mendes.svg',
                'skills' => ['Python', 'TensorFlow', 'MLOps', 'Airflow', 'Data Storytelling'],
                'languages' => [
                    ['name' => 'Portuguese', 'level' => 'Native'],
                    ['name' => 'English', 'level' => 'Fluent'],
                    ['name' => 'Spanish', 'level' => 'Intermediate'],
                ],
                'work_experience' => [
                    [
                        'position' => 'Lead Data Scientist',
                        'company' => 'Atlas Commerce',
                        'country' => 'Brazil',
                        'city' => 'São Paulo',
                        'from' => '2021-03',
                        'to' => Carbon::now()->format('Y-m'),
                        'currently' => true,
                        'achievements' => 'Built real-time recommendations increasing conversion by 18% '
                            . 'while reducing inference costs 30%.',
                    ],
                    [
                        'position' => 'Machine Learning Engineer',
                        'company' => 'Insight Analytics',
                        'country' => 'Brazil',
                        'city' => 'São Paulo',
                        'from' => '2017-09',
                        'to' => '2021-02',
                        'currently' => false,
                        'achievements' => 'Deployed forecasting pipelines serving 200+ retail stores '
                            . 'with automated monitoring.',
                    ],
                ],
                'education' => [
                    [
                        'institution' => 'Universidade de São Paulo',
                        'degree' => 'MSc',
                        'field' => 'Computer Science',
                        'country' => 'Brazil',
                        'city' => 'São Paulo',
                        'start_year' => '2013',
                        'end_year' => '2015',
                    ],
                    [
                        'institution' => 'Universidade Federal do Rio de Janeiro',
                        'degree' => 'BSc',
                        'field' => 'Applied Mathematics',
                        'country' => 'Brazil',
                        'city' => 'Rio de Janeiro',
                        'start_year' => '2009',
                        'end_year' => '2012',
                    ],
                ],
                'hobbies' => ['Trail Running', 'Jazz Guitar', 'Urban Gardening'],
                'extra_curriculum_activities' => ['Mentor, Data for Good Brazil', 'Co-organiser, PyData São Paulo'],
            ],
        ];

        foreach ($records as $record) {
            $userEmail = Arr::pull($record, 'user_email');
            $user = User::where('email', $userEmail)->first();

            if (! $user) {
                throw new \RuntimeException("Unable to seed CV data because the user '{$userEmail}' does not exist.");
            }

            $attributes = array_merge($record, [
                'user_id' => $user->id,
                'birthday' => isset($record['birthday']) ? Carbon::parse($record['birthday'])->toDateString() : null,
            ]);

            Cv::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'first_name' => $attributes['first_name'],
                    'last_name' => $attributes['last_name'],
                ],
                $attributes
            );
        }
    }
}
