<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            "first_name" => "Test",
            "middle_name" => "",
            "last_name" => "Staff",
            "type" => "staff",
            "email" => "test.staff@gmail.com",
            "password" => "password",
            "phone" => "+2349037426727",
            "gender" => "M",
            "dob" => "1790-01-01",
            "address" => "No 16 Akinpelu Close, Iyana Oworo Lagos, Nigeria",
            "remember_token" => Str::random(10),
            "email_verified_at" => now()
        ]);

        $this->call([
            UserSeeder::class,
            MenuSeeder::class,
            OrderSeeder::class
        ]);
    }
}
