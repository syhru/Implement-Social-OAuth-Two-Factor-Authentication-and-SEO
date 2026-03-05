<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a default Admin User
        $admin = User::firstOrCreate([
            'email' => 'muhamadarul746@gmail.com'
        ], [
            'name' => 'Syahru',
            'password' => bcrypt('password'),
            'two_factor_enabled' => true,
        ]);

        // 2. Create Categories (Tech Focused)
        $categoriesData = ['Teknologi', 'Programming', 'Cloud Computing', 'Artificial Intelligence', 'Cyber Security'];
        $categories = collect();

        foreach ($categoriesData as $cat) {
            $categories->push(Category::firstOrCreate([
                'slug' => Str::slug($cat)
            ], [
                'name' => $cat
            ]));
        }

        // 3. Create Tags (Tech Focused)
        $tagsData = ['Laravel', 'Python', 'AWS', 'Docker', 'Machine Learning', 'Pentesting', 'React', 'API', 'Serverless', 'Encryption'];
        $tags = collect();

        foreach ($tagsData as $tag) {
            $tags->push(Tag::firstOrCreate([
                'slug' => Str::slug($tag)
            ], [
                'name' => $tag
            ]));
        }

        // Posts are not seeded — admin creates articles manually via the dashboard.
    }
}
