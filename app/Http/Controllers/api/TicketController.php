<?php


namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\RoleResource;
use App\Models\Ticket;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Resources\TicketDetailResource;
use App\Http\Resources\TicketResource;
use App\Http\Resources\UnitResource;
use App\Http\Resources\UserResource;
use App\Models\Comment;
use App\Models\Unit;

class TicketController extends Controller
{
    public function index() {
        $role = auth()->user()->role_id;

        $query = Ticket::with(['category:id,name', 'user:id,name'])
            ->filter(request(['search', 'category']))
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1);
            })
            ->latest();

        if (request('order_by') == 'oldest') {
            $query = Ticket::with(['category:id,name', 'user:id,name'])
                ->filter(request(['search', 'category']))
                ->whereHas('category', function ($query) {
                    $query->where('is_active', 1);
                });
        }

        if ($role == 1) {
            // Super Admin
            if (request('order_by') == 'solved') {
                $query->finished();
            } else if (request('order_by') == 'unsolved') {
                $query->unfinished();
            }
        } else if ($role == 2) {
            // Admin
            $query->where('unit_id', auth()->user()->unit_id);

            if (request('order_by') == 'solved') {
                $query->finished();
            } else if (request('order_by') == 'unsolved') {
                $query->unfinished();
            }
        } else if ($role == 3) {
            // User
            $query->where('user_id', auth()->user()->id);

            if (request('order_by') == 'solved') {
                $query->finished();
            } else if (request('order_by') == 'unsolved') {
                $query->unfinished();
            }
        } else if ($role == 4) {
            // Admin Category
            $query->where('category_id', auth()->user()->admin_category_id);

            if (request('order_by') == 'solved') {
                $query->finished();
            } else if (request('order_by') == 'unsolved') {
                $query->unfinished();
            }
        } else {
            $query->where('id', 0);
        }

        $tickets = $query->get();
        $data = TicketResource::collection($tickets);

        if ($data) {
            return response()->json([
                'message' => 'success',
                'tickets' => $data
            ], 200);
        }

        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function ticketsUnit(Unit $unit) {
        $query = Ticket::where('unit_id', $unit->id)
        ->whereHas('category', function ($query) {
            $query->where('is_active', 1);
        })
        ->filter(request(['search', 'category']));

        if (request('order_by') == 'oldest') {
            $query->oldest();
        }
        
        if (request('order_by') == 'solved') {
            $query->finished();
        } else if (request('order_by') == 'unsolved') {
            $query->unfinished();
        }

        $tickets = $query->latest()->get();
        $data = TicketResource::collection($tickets);

        if($data) {
            return response()->json([
                'message' => 'success',
                'tickets' => $data 
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function show(Ticket $ticket) {
        $data = new TicketDetailResource($ticket->loadMissing(['category:id,name', 'user:id,name']));
        
        $ticket_comments = Comment::latest()->where('ticket_id', $ticket->id)
        ->whereNull('parent_id')
        ->with(['user:id,name,role_id', 'replies.user:id,name,role_id'])
        ->get();

        if($data) {
            $data['user'] = new UserResource($data->user);
            $data['user']['unit'] = new UnitResource($data->user->unit);
            $data['user']['role'] = new RoleResource($data->user->role);

            $data['category'] = new CategoryResource($data->category);
            
            return response()->json([
                'message' => 'success',
                'tickets' => $data,
                'ticket_comments' => $ticket_comments,
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
            'category_id' => 'required',
            'body' => 'required',
            'report_date' => 'required',
            'attachment' => '',
        ]);

        $validatedData['slug'] = $request->slug . '-' . uniqid();
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['unit_id'] = auth()->user()->unit_id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);

        $ticket = Ticket::create($validatedData);

        $data = new TicketDetailResource($ticket->loadMissing(['category:id,name']));

        if($data) {
            return response()->json([
                'message' => 'success',
                'ticket' => $data 
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function update(Ticket $ticket) {
        $ticketData = Ticket::findorfail($ticket->id);
        
        $updateData = [
            'is_finished' => 2,
        ];

        $ticketData->update($updateData);

        $data = new TicketDetailResource($ticketData);

        if($data) {
            return response()->json([
                'message' => 'success',
                'ticket' => $data 
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }
}