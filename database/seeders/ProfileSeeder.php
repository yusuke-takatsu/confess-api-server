<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id')->toArray();

        $profiles = [];
        foreach($userIds as $userId) {
            $profile = Profile::factory()->make([
                'user_id' => $userId,
            ])->toArray();
            $profile['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $profile['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

            $profiles[] = $profile;
        }

        Profile::insert($profiles);
    }
}
