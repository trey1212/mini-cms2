<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'a@a.a',
            'password' => Hash::make('P@$$w0rd'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create a long article
        DB::table('articles')->insert([
            'title' => "Long Article",
            'content' => "<p>This is a long article content. " . str_repeat("Lorem ipsum dolor sit amet, consectetur adipiscing elit. ", 20) . "</p>",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create 6 articles
        for ($i = 1; $i <= 6; $i++) {
            DB::table('articles')->insert([
                'title' => "Article $i",
                'content' => "<p>This is article $i content</p>",
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
