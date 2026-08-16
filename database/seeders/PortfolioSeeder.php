<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        Profile::updateOrCreate(['id' => 1], [
            'full_name'    => 'Escaret, Race Jhone Minard P.',
            'role_title'   => 'Computer Science Graduate — IT & Systems Development',
            'location'     => 'Brgy. Osorio, Trece Martires City, Cavite',
            'phone'        => '0977 0077 284',
            'email'        => 'rjm.escaret@gmail.com',
            'objective'    => 'Aspiring IT professional and Computer Science graduate with experience in systems development, troubleshooting, and software-related projects. Passionate about technology, cybersecurity, and application development, with a strong willingness to learn and contribute in a professional environment.',
            'case_number'  => '2026-CS-ESC',
            'status'       => 'ACTIVE',
            'github_url'   => null,
            'linkedin_url' => null,
        ]);

        $educations = [
            ['title' => 'BS Computer Science', 'institution' => 'Systems Technology Institute – Dasmariñas', 'date_range' => '2022 – 2026', 'sort_order' => 1],
            ['title' => 'Humanities and Social Science', 'institution' => 'Francisco Osorio Integrated Senior High School', 'date_range' => '2018 – 2020', 'sort_order' => 2],
        ];
        foreach ($educations as $row) {
            Education::updateOrCreate(['title' => $row['title'], 'institution' => $row['institution']], $row);
        }

        $skills = [
            ['category' => 'language', 'name' => 'Java', 'sort_order' => 1],
            ['category' => 'language', 'name' => 'Python', 'sort_order' => 2],
            ['category' => 'language', 'name' => 'C#', 'sort_order' => 3],

            ['category' => 'core', 'name' => 'Object-Oriented Programming', 'sort_order' => 1],
            ['category' => 'core', 'name' => 'Data Structures', 'sort_order' => 2],
            ['category' => 'core', 'name' => 'Application Development', 'sort_order' => 3],
            ['category' => 'core', 'name' => 'Cybersecurity Fundamentals', 'sort_order' => 4],

            ['category' => 'tool', 'name' => 'GitHub', 'sort_order' => 1],
            ['category' => 'tool', 'name' => 'VS Code', 'sort_order' => 2],
            ['category' => 'tool', 'name' => 'PyCharm', 'sort_order' => 3],
            ['category' => 'tool', 'name' => 'Android Studio', 'sort_order' => 4],

            ['category' => 'soft', 'name' => 'Analytical & Critical Thinking', 'sort_order' => 1],
            ['category' => 'soft', 'name' => 'Problem Solving', 'sort_order' => 2],
            ['category' => 'soft', 'name' => 'Team Collaboration', 'sort_order' => 3],
            ['category' => 'soft', 'name' => 'Time Management', 'sort_order' => 4],
            ['category' => 'soft', 'name' => 'Professional Communication', 'sort_order' => 5],
            ['category' => 'soft', 'name' => 'Attention to Detail', 'sort_order' => 6],
            ['category' => 'soft', 'name' => 'Adaptability', 'sort_order' => 7],
        ];
        foreach ($skills as $row) {
            Skill::updateOrCreate(['category' => $row['category'], 'name' => $row['name']], $row);
        }

        $experiences = [
            [
                'title' => 'Systems Development Department',
                'organization' => 'Wellcare Clinics and Lab Inc.',
                'date_range' => 'Jan 2026 – Mar 2026',
                'bullets' => [
                    'Assisted in system development and technical support tasks within the department',
                    'Collaborated with team members in troubleshooting and maintaining internal systems',
                    'Gained hands-on experience in professional workplace environments and IT workflows',
                ],
                'sort_order' => 1,
            ],
            [
                'title' => 'Self-Employed Computer Repair Technician',
                'organization' => null,
                'date_range' => '2022 – Present',
                'bullets' => [
                    'Diagnosed and resolved hardware and software issues for desktops and laptops',
                    'Performed OS installations, reformatting, and system optimization',
                    'Installed and configured essential software and peripherals',
                    'Managed service requests independently',
                ],
                'sort_order' => 2,
            ],
            [
                'title' => 'Fast Food Service Team Member',
                'organization' => 'KFC',
                'date_range' => '2022',
                'bullets' => [
                    'Delivered customer service in a fast-paced environment',
                    'Assisted in order processing, food preparation, and store operations',
                    'Practiced team coordination, time management, and customer interaction skills',
                ],
                'sort_order' => 3,
            ],
            [
                'title' => 'Library Assistant — Senior High School OJT',
                'organization' => 'Trece Martires City Colleges',
                'date_range' => '2019',
                'bullets' => [
                    'Assisted students and staff with library resources and basic records management',
                    'Organized books and maintained a clean, orderly study environment',
                ],
                'sort_order' => 4,
            ],
        ];
        foreach ($experiences as $row) {
            Experience::updateOrCreate(['title' => $row['title'], 'date_range' => $row['date_range']], $row);
        }

        $projects = [
            [
                'tag' => 'Cybersecurity',
                'title' => 'Fixion',
                'subtitle' => 'AI-Driven Threat Detection and Automated System Restoration',
                'description' => 'A cybersecurity system built to strengthen protection and recovery for the computer laboratories at STI College Dasmariñas, incorporating adaptive learning and automated security features.',
                'sort_order' => 1,
            ],
            [
                'tag' => 'Mobile App',
                'title' => 'Cafe Hunt',
                'subtitle' => 'Location-based coffee shop finder',
                'description' => 'A mobile app that helps users find nearby coffee shops quickly using map integration — surfacing distance, location, and availability for each spot around the user.',
                'sort_order' => 2,
            ],
        ];
        foreach ($projects as $row) {
            Project::updateOrCreate(['title' => $row['title']], $row);
        }
    }
}
