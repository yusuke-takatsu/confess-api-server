<?php

namespace Tests\Feature\Profile;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_success(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user, 'user')
          ->post(route('profile.update', [
            'id' => $profile->id,
            'name' => 'test',
            'image' => null,
          ]));

        $response->assertStatus(200)
          ->assertJson([
              'message' => 'プロフィール情報を更新しました。'
          ]);
        
        $this->assertDatabaseHas('profiles', [
            'name' => 'test',
            'image' => null,
        ]);
    }

    public function test_not_found(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'user')
          ->post(route('profile.update', [
            'id' => 1,
            'name' => 'テスト',
            'image' => null,
          ]));

        $response->assertStatus(200)
          ->assertJson([
              'message' => '更新対象のプロフィールが存在しません。'
          ]);
    }
}
