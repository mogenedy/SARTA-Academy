<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $about = About::create([
            'title' => 'About Us',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, eaque!',
            'vision' => [
                'Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, eaque!',
                'Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, eaque!',
                'Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, eaque!',
            ],
            'mission' => [
                'Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, eaque!',
                'Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, eaque!',
                'Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, eaque!',
            ],
            'objectives' => [
                'Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, eaque!',
                'Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, eaque!',
                'Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, eaque!',
            ]
        ]);

        $about->addMediaFromUrl('https://picsum.photos/id/237/200/300')->toMediaCollection('main');
    }
}
