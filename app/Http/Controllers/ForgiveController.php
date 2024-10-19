<?php

namespace App\Http\Controllers;

use App\Http\Requests\Forgive\ToggleRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ForgiveController extends Controller
{
    public function toggle(ToggleRequest $request)
    {
        /** @var User */
        $user = Auth::user();

        $post = Post::find($request->input('post_id'));
        if (is_null($post)) {
          return response()->json([
            'message' => '対象の投稿が存在しません。'
          ], 404);
        }


        if ($request->input('is_forgive')) {
          $user->forgives()->syncWithoutDetaching($request->input('post_id'));

          return response()->json([
            'message' => '「赦す」を登録しました。'
          ], 200);
        }

        $user->forgives()->detach($request->input('post_id'));

        return response()->json([
          'message' => '「赦す」を解除しました。'
        ], 200);
    }
}
