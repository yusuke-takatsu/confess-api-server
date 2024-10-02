<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\StoreRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function store(StoreRequest $request)
    {
        $userId = Auth::id();
        $existsProfile = Profile::where('user_id', $userId)->exists();

        if ($existsProfile) {
          return response()->json([
            'message' => 'すでにプロフィールが登録されています。'
          ]);
        }

        if (is_null($request->image)) {
          Profile::create([
              'user_id' => $userId,
              'name' => $request->name,
              'image' => null,
          ]);

          return response()->json([
            'message' => 'プロフィール情報を登録しました。'
          ]);
        }

        $extension = $request->image->extension();
        $fileName = Str::uuid().'.'.$extension;

        $uploadedFilePath = Storage::disk('s3')->putFile('images', $request->image, $fileName);

        Profile::create([
          'user_id' => $userId,
          'name' => $request->name,
          'image' => $uploadedFilePath,
        ]);

        return response()->json([
          'message' => 'プロフィール情報を登録しました。'
        ]);
    }
}
