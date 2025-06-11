<?php

namespace Database\Seeders;

use App\Models\AboutHome;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutHomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aboutHome = AboutHome::create([
            'title' => 'About Us',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
            'is_slider' => true
        ]);

        $aboutHome->addMediaFromUrl('https://picsum.photos/id/237/200/300')->toMediaCollection('main');

    }
}
