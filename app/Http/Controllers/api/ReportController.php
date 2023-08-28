<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketDetailResource;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
    
        $query = Ticket::whereDate('report_date', '>=', $startDate)
        ->whereDate('report_date', '<=', $endDate)
        ->groupBy(DB::raw('DATE(report_date)'), 'report_date') // Menyertakan kolom 'report_date' dalam GROUP BY
        ->selectRaw('DATE_FORMAT(report_date, "%d-%m-%Y") as formatted_date, 
            COUNT(*) as ticket_count, 
            SUM(CASE WHEN is_finished = 2 THEN 1 ELSE 0 END) as finished_count,
            SUM(CASE WHEN is_finished != 2 THEN 1 ELSE 0 END) as unfinished_count')
        ->orderBy('formatted_date');

        if (auth()->user()->role_id === 2) {
            $query->where('unit_id', auth()->user()->unit_id);
        }

        $ticketData = $query->get();
    
        if ($ticketData) {
            return response()->json([
                'message' => 'success',
                'ticketData' => $ticketData
            ], 200);
        }
    
        return response()->json([
            'message' => 'error',
        ], 500);
    }
}