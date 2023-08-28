<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopicDetailResource;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role_id;
        $topics = Topic::query();

        if ($role != 2) {
            $topics->where('is_active', 1);
        }

        $topics = $topics->get();

        $data = TopicResource::collection($topics);

        if ($data) {
            return response()->json([
                'message' => 'success',
                'topics' => $data 
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required',
        ]);

        $validatedData['unit_id'] = auth()->user()->unit_id; 

        $topic = Topic::create($validatedData);
        
        $data = new TopicResource($topic);

        if($data) {
            return response()->json([
                'message' => 'success',
                'topics' => $data 
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function update(Request $request, Topic $topic)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'slug' => 'required',
        ]);

        if($request->slug != $topic->slug) {
            $validatedData['slug'] = $request->slug;
        }
        
        $data = Topic::where('id', $topic->id)
            ->update($validatedData);

        if($data) {
            return response()->json([
                'message' => 'success',
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function toggleStatus(Topic $topic) {
        $data = Topic::where('id', $topic->id);

        if($topic->is_active == 0) {
            $data->update(['is_active' => 1]);
        } else if ($topic->is_active == 1) {
            $data->update(['is_active' => 0]);
        }
        
        if($data) {
            return response()->json([
                'message' => 'success',
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function destroy($id)
    {
        $data = Topic::destroy($id);

        if($data) {
            return response()->json([
                'message' => 'success',
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }
}