<?php

namespace Database\Seeders;

use App\Models\HomeCounter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeCounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomeCounter::create([
            'title' => 'Total Students',
            'number' => '30K',
        ]);

        HomeCounter::create([
            'title' => 'Total Courses',
            'number' => '20K',
        ]);

        HomeCounter::create([
            'title' => 'Total Instructors',
            'number' => '12K',
        ]);

        HomeCounter::create([
            'title' => 'Total Events',
            'number' => '9K',
        ]);


    }
}
