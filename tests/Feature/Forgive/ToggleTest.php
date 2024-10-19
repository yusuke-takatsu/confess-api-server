<?php

namespace Tests\Feature\Forgive;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToggleTest extends TestCase
{
    use RefreshDatabase;

    public function test_success(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user, 'user')
          ->post(route('forgive.toggle', [
            'post_id' => $post->id,
            'is_forgive' => true,
          ]));

        $response->assertStatus(200)
          ->assertJson([
              'message' => '「赦す」を登録しました。'
          ]);
        
        $this->assertDatabaseHas('forgives', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    public function test_post_not_found(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'user')
          ->post(route('forgive.toggle', [
            'post_id' => 1,
            'is_forgive' => true,
          ]));

        $response->assertStatus(404)
          ->assertJson([
              'message' => '対象の投稿が存在しません。'
          ]);
    }
}
