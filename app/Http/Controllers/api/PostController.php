<?php


namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\TopicResource;
use App\Http\Resources\UnitResource;
use App\Http\Resources\UserResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index() {

        $query = Post::with(['category:id,name', 'topic:id,title', 'user:id,name'])
        ->whereHas('category', function ($query) {
            $query->where('is_active', 1);
        })
        ->whereHas('topic', function ($query) {
            $query->where('is_active', 1);
        })
        ->unit()
        ->filter(request(['search', 'category', 'topic']))
        ->latest();

        if (request('order_by') == 'solved') {
            $query->finished()->latest();
        } else if (request('order_by') == 'unsolved') {
            $query->unfinished()->latest();
        } else if (request('order_by') == 'oldest') {
            $query = Post::with(['category:id,name', 'topic:id,title', 'user:id,name'])->filter(request(['search', 'category', 'topic']));
        }

        $posts = $query->get();
        $data = PostResource::collection($posts);

        if ($data) {
            return response()->json([
                'message' => 'success',
                'posts' => $data
            ], 200);
        }

        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function postsUnit(Unit $unit) {
        $query = Post::where('unit_id', $unit->id)
        ->filter(request(['search', 'category']))
        ->whereHas('category', function ($query) {
            $query->where('is_active', 1);
        })
        ->whereHas('topic', function ($query) {
            $query->where('is_active', 1);
        });

        if (request('order_by') == 'oldest') {
            $query->oldest();
        }
        
        if (request('order_by') == 'solved') {
            $query->finished();
        } else if (request('order_by') == 'unsolved') {
            $query->unfinished();
        }

        $posts = $query->latest()->get();
        $data = PostResource::collection($posts);

        if($data) {
            return response()->json([
                'message' => 'success',
                'posts' => $data 
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }
    
    public function show(Post $post) {
        $data = new PostDetailResource($post->loadMissing(['category:id,name', 'topic:id,title', 'user:id,name', 'comments']));

        $post_comments = Comment::latest()->where('post_id', $post->id)
        ->whereNull('parent_id')
        ->with(['user:id,name,role_id', 'replies.user:id,name,role_id'])
        ->get();

        if($data) {
            $data['user'] = new UserResource($data->user);
            $data['user']['unit'] = new UnitResource($data->user->unit);
            $data['user']['role'] = new RoleResource($data->user->role);

            $data['category'] = new CategoryResource($data->category);
            $data['topic'] = new TopicResource($data->topic);
            
            $data = new PostDetailResource($post->loadMissing(['category:id,name', 'topic:id,title', 'user:id,name', 'comments']));
            
            return response()->json([
                'message' => 'success',
                'posts' => $data,
                'post_comments' => $post_comments,
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required',
            'topic_id' => 'required',
            'category_id' => 'required',
            'body' => 'required'
        ]);

        $validatedData['slug'] = $request->slug . '-' . uniqid();
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['unit_id'] = auth()->user()->unit_id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);

        $post = Post::create($validatedData);

        $data = new PostDetailResource($post);

        if($data) {
            return response()->json([
                'message' => 'success',
                'post' => $data 
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function update(Post $post) {
        $postData = Post::findorfail($post->id);
        
        $updateData = [
            'is_finished' => 1,
        ];

        $postData->update($updateData);

        $data = new PostDetailResource($postData);

        if($data) {
            return response()->json([
                'message' => 'success',
                'post' => $data 
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }
}