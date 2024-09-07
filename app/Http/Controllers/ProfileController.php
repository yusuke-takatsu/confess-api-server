<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

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

        return response()->json($profile);
    }
}
