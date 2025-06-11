<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Institute;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            AboutHomeSeeder::class,
            AboutSeeder::class,
            DirectorMessageSeeder::class,
            HomeCounterSeeder::class,
            PatentCounterSeeder::class,
            PublicationDataSeeder::class,

            CategorySeeder::class,
            InstituteSeeder::class,
            CourseSeeder::class,
            LessonSeeder::class,
            DepartmentSeeder::class,
        ]);
        
    }
}
