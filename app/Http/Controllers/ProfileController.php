<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show($id)
    {
        $profile = Profile::find($id);
        
        if (is_null($profile)) {
          return response()->json([
              'message' => 'プロフィールが存在しません。'
          ]);
        }

        $imagePath = Storage::disk('s3')->url(config('filesystems.disks.s3.bucket').'/'.$profile->image);

        return response()->json([
          'id' => $profile->id,
          'name' => $profile->name,
          'image' => $imagePath
        ]);
    }
}
