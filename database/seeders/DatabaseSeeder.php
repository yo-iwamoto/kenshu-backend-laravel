<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Initial User',
            'email' => 'sample@example.com',
        ]);
        User::factory(10)->create();

        $tag_names = [
            '総合',
            'テクノロジー',
            'モバイル',
            'アプリ',
            'エンタメ',
            'ビューティー',
            'ファッション',
            'ライフスタイル',
            'ビジネス',
            'グルメ',
            'スポーツ',
        ];

        foreach ($tag_names as $tag_name) {
            Tag::create([
                'name' => $tag_name,
            ]);
        }
    }
}
