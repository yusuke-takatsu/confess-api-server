<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\IndexRequest;
use App\Models\Post;

class PostController extends Controller
{
  public function index(IndexRequest $request)
  {
    // リクエストからパラメータを取得
    $searchWord = $request->input('search_word');
    $categoryId = $request->input('category_id');
    $sortBy = $request->input('sort_by');
    $sortType = $request->input('sort_type');

    $query = Post::select('posts.*', 'users.name', 'users.image')
      ->join('users', 'posts.user_id', '=', 'users.id');

    // search_wordが存在する場合の条件追加
    if ($searchWord) {
      $query->where(function ($q) use ($searchWord) {
        $q->where('users.name', 'like', '%' . $searchWord . '%')
          ->orWhere('posts.content', 'like', '%' . $searchWord . '%');
      });
    }

    // category_idが存在する場合の条件追加
    if ($categoryId) {
      $query->where('posts.category_id', $categoryId);
    }

    // ソート条件の適用
    if ($sortBy && $sortType) {
      $query->orderBy($sortBy, $sortType);
    }

    // get()で実際にデータを取得
    $posts = $query->get();

    return response()->json($posts);
  }
}