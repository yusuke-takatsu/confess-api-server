<?php

namespace Tests\Feature\Profile;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_success(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user, 'user')
          ->get(route('profile.show', ['id' => $profile->id]));

        $response->assertStatus(200)
          ->assertJson([
              'id' => $profile->id,
              'name' => $profile->name,
              'image' => $profile->image,
              'created_at' => $profile->created_at->toJSON(),
              'updated_at' => $profile->updated_at->toJSON(),
          ]);
    }

    public function test_not_found(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'user')
          ->get(route('profile.show', ['id' => 1]));

        $response->assertStatus(200)
          ->assertJson([
              'message' => 'プロフィールが存在しません。'
          ]);
    }
}
