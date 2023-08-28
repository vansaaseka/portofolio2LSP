<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::with(['category:id,name', 'tickets', 'posts'])->get();

        $data = UnitResource::collection($units);

        if($data) {
            return response()->json([
                'message' => 'success',
                'units' => $data 
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }
}