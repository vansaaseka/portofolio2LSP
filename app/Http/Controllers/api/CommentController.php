<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Ticket;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function storePost(Request $request)
    {
        $validatedData = $request->validate([
            'post_id' => 'required',
            'body' => 'required'
        ]);
        
        $validatedData['parent_id'] = $request->parent_id != '' ? $request->parent_id:NULL;
        $validatedData['user_id'] = auth()->user()->id;

        $data = Comment::create($validatedData);

        if($data) {
            return response()->json([
                'message' => 'success',
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500); 
    }

    public function storeTicket(Request $request)
    {
        $validatedData = $request->validate([
            'ticket_id' => 'required',
            'body' => 'required'
        ]);
        
        $validatedData['parent_id'] = $request->parent_id != '' ? $request->parent_id:NULL;
        $validatedData['user_id'] = auth()->user()->id;

        $data = Comment::create($validatedData);

        $userRoleId = auth()->user()->role_id;

        if ($userRoleId === 1 || $userRoleId === 2 || $userRoleId === 4) {
            $ticketData = Ticket::findOrFail($request->ticket_id);
            $ticketData->update(['is_finished' => 1]);
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
}