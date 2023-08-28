<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Ticket;
use App\Models\Topic;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    public function index() {
        $tickets = Ticket::all()->count();
        $finishedTickets = Ticket::finished()->count();
        $posts = Post::all()->count();
        $topics = Topic::all();
        $users = User::where('role_id', 3)->count();
        $staff = User::where('role_id', 2)->count();
        $unit = Unit::all()->count();
        $faq = Faq::all();
        $categories = PostCategory::all()->count();

        return response()->json([
            'message' => 'success',
            'tickets' => $tickets,
            'finishedTickets' => $finishedTickets,
            'posts' => $posts,
            'topics' => $topics,
            'users' => $users,
            'staff' => $staff,
            'unit' => $unit,
            'faq' => $faq,
            'categories' => $categories,
        ], 200);
    }

    public function chartData()
    {
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $postHistory = Post::whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get([
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            ]);

        $ticketHistory = Ticket::whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get([
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            ]);
            
        if(auth()->user()->role_id == 2) {
            $postHistory = Post::whereBetween('created_at', [$startDate, $endDate])
            ->unit()
            ->groupBy('date')
            ->orderBy('date')
            ->get([
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            ]);

            $ticketHistory = Ticket::whereBetween('created_at', [$startDate, $endDate])
                ->unit()
                ->groupBy('date')
                ->orderBy('date')
                ->get([
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as count')
            ]);
        }
        
        $labels = [];
        $postCounts = [];
        $ticketCounts = [];

        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $formattedDate = $currentDate->format('Y-m-d');
            $labels[] = $formattedDate;

            $postCount = $postHistory->firstWhere('date', $formattedDate);
            $postCounts[] = $postCount ? $postCount->count : 0;

            $ticketCount = $ticketHistory->firstWhere('date', $formattedDate);
            $ticketCounts[] = $ticketCount ? $ticketCount->count : 0;

            $currentDate->addDay();
        }

        $data = [
            'labels' => $labels,
            'postCounts' => $postCounts,
            'ticketCounts' => $ticketCounts
        ];

        return response()->json($data);
    }
}