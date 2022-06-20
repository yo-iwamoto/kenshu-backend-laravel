<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class EditTest extends TestCase
{
    private User $user;
    private User $other_user;
    private string $uri;
    private string $unauthorized_uri;

    public function setUp(): void
    {
        parent::setUp();

        $dammy_users = User::factory()->count(2)->create();
        $this->user = $dammy_users[0];
        $this->other_user = $dammy_users[1];

        $post = Post::create([
            'user_id' => $this->user->id,
            'title' => $this->faker->randomAscii(),
            'content' => $this->faker->randomAscii(),
        ]);

        $this->uri = route('post.edit', ['post' => $post->id]);
        $this->unauthorized_uri = '/';
    }

    public function test_作成者がログイン状態で正常にアクセスできること(): void
    {
        $this->actingAs($this->user)
            ->get($this->uri)
            ->assertOk()
            ->assertViewIs('post.edit');
    }

    public function test_作成者以外がログイン状態でトップにリダイレクトされること(): void
    {
        $this->actingAs($this->other_user)
            ->get($this->uri)
            ->assertRedirect($this->unauthorized_uri);
    }

    public function test_未認証状態でトップにリダイレクトされること(): void
    {
        $this->get($this->uri)
            ->assertRedirect($this->unauthorized_uri);
    }
}
