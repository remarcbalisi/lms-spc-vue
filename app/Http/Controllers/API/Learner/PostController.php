<?php

namespace App\Http\Controllers\API\Learner;

use App\Post;
use App\PostCategory;
use App\PostType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function store(Request $request) {
        $post_category = PostCategory::where('slug', $request->post_category)->first();
        $post_type = PostType::where('slug', $request->post_type)->first();
        $new_post = new Post;
        $new_post->title = $request->title ? $request->title : $post_category->name;
        $new_post->body = $request->body;
        $new_post->post_type_id = $post_type->id;
        $new_post->posted_by = auth()->user()->id;
        $new_post->classroom_id = $request->classroom_id ? $request->classroom_id : null;
        $new_post->post_category_id = $post_category->id;
        $new_post->save();
        return response()->json([
            'data' => $new_post,
            'status' => 200,
            'message' => 'Successfully posted ' . $new_post->title,
        ]);
    }

    public function getClassroomPost($classroom_id) {
        $posts = Post::where('classroom_id', $classroom_id)->latest()->get();
        foreach( $posts as $post ) {
            $post['posted_by'] = $post->postedBy()->first();
            $post['post_type'] = $post->postType()->first();
            $post['post_category'] = $post->postCategory()->first();
        }
        return response()->json([
            'data' => $posts,
            'status' => 200,
            'message' => 'Successfully get all posts',
        ]);
    }
}
