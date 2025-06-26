<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'first_name' => 'Mikael',
            'last_name' => 'Jones',
            'email' => 'test@example.com',
        ]);

        $tag = Tag::factory(10)->create();
        Article::factory()
            ->count(20)
            ->hasAttached($tag)
            ->create([
                'user_id' => $user->id,
            ]);
    }
}
