<?php

namespace Database\Seeders;

use App\Models\PublicationData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublicationDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PublicationData::create([
            'scopus_link' => 'https://www.scopus.com',
            'research_gate_link' => 'https://www.researchgate.net',
            'web_of_science_link' => 'https://www.webofscience.com',
            'graph' => [
                [
                    'record' => [
                        [
                            'year' => '2020',
                            'number' => 1
                        ],
                        [
                            'year' => '2021',
                            'number' => 2
                        ],
                        [
                            'year' => '2022',
                            'number' => 3
                        ]
                    ],
                    'title' => [
                        'en' => 'test',
                        'ar' => 'test'
                    ]
                ]
            ]     
        ]);
    }
}
