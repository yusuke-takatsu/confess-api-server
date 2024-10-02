<?php

namespace Tests\Feature\Profile;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_success(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'user')
          ->post(route('profile.store', [
            'name' => 'test',
            'image' => null,
          ]));

        $response->assertStatus(200)
          ->assertJson([
              'message' => 'プロフィール情報を登録しました。'
          ]);
        
        $this->assertDatabaseHas('profiles', [
            'name' => 'test',
            'image' => null,
        ]);
    }

    public function test_already_profile(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user, 'user')
          ->post(route('profile.store', [
            'name' => $profile->name,
            'image' => null,
          ]));

        $response->assertStatus(200)
          ->assertJson([
              'message' => 'すでにプロフィールが登録されています。'
          ]);
    }
}
