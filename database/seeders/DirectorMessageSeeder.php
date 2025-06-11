<?php

namespace Database\Seeders;

use App\Models\AboutHome;
use App\Models\DirectorMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirectorMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $directorMessage = DirectorMessage::create([
            'title' => 'DirectorMessage',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
        ]);

        $directorMessage->addMediaFromUrl('https://picsum.photos/id/237/200/300')->toMediaCollection('main');

    }
}
