<?php

namespace App\Http\Middleware;

use App\Models\Ticket;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if(auth()->guest() || auth()->user()->role->name != 'admin') {
        //     abort(403);
        // }

        
        // dd($request->id);
        
        $ticket = Ticket::findOrFail($request->id);
        
        if($ticket->user_id != auth()->user()->id) {
            return response()->json([
                "message" => 'data not found'
            ], 404);
        }
        
        return $next($request);
        // return response()->json($ticket->user_id);
    }
}