<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // register phone null
        // show llphone in arabic or english fe el mobile
        // show department limit data
        // course index
        // lesson show course_id null
        // prizees reseearcher null
        
        Role::create(['name' => 'super_admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'researcher']);
        Role::create(['name' => 'editor']);
        Role::create(['name' => 'client']);

        $super = User::create([
           'name' => [
               'en' => "SuperAdmin",
               'ar' => "سوبر ادمن"
           ],
           "email" => "SuperAdmin@SRTA.edu.eg",
           "phone" => "0123456789",
           "password" => bcrypt("12345678"),
        ]);

        $admin = User::create([
            'name' => [
                "en" => "Admin",
                "ar" => "ادمن"
            ],
            "email" => "Admin@SRTA.edu.eg",
            "phone" => "0123456789",
            "password" => bcrypt("12345678"),
        ]);

        $client = User::create([
            'name' => [
                "en" => "Client",
                "ar" => "عميل"
            ],
            "email" => "normal-client@SRTA.edu.eg",
            "phone" => "0123456789",
            "password" => bcrypt("12345678"),
        ]);

        $researcher = User::create([
            'name' => [
                "en" => "researcher",
                "ar" => "باحث"
            ],
            "email" => "researcher@SRTA.edu.eg",
            "phone" => "0123456789",
            "password" => bcrypt("12345678"),
        ]);


        $researcher2 = User::create([
            'name' => [
                "en" => "researcher2",
                "ar" => "2باحث"
            ],
            "email" => "researcher2@SRTA.edu.eg",
            "phone" => "0123456789",
            "password" => bcrypt("12345678"),
        ]);

        $researcher3 = User::create([
            'name' => [
                "en" => "researcher3",
                "ar" => "3باحث"
            ],
            "email" => "researcher3@SRTA.edu.eg",
            "phone" => "0123456789",
            "password" => bcrypt("12345678"),
        ]);

        $super->assignRole('super_admin');
        $admin->assignRole('admin');
        $client->assignRole('client');
        $researcher->assignRole('researcher');
        $researcher2->assignRole('researcher');
        $researcher3->assignRole('researcher');


    }
}
