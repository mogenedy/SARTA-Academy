<?php

namespace Database\Seeders;

use App\Models\PatentCounter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatentCounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PatentCounter::create([
            'issued' => 185,
            'pending' => 37
        ]);
    }
}
