<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            "name"              => "Sm Shahjalal Shaju",
            "email"             => "shajushahjalal@gmail.com",
            "group_id"          => 1,
            "password"          => bcrypt("shajushahjalal@gmail.com"),
            "email_verified_at" => now(),
            "remember_token"    => Str::random(32),
        ]);

        Admin::create([
            "name"              => "Admin",
            "email"             => "admin@admin.com",
            "group_id"          => 1,
            "password"          => bcrypt("admin@admin.com"),
            "email_verified_at" => now(),
            "remember_token"    => Str::random(32),
        ]);
    }
}
