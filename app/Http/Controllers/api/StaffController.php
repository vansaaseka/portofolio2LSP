<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserDetailResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index() {
        $users = User::where('role_id', 2)->get();

        $data = UserResource::collection($users);

        if($data) {
            return response()->json([
                'message' => 'success',
                'users' => $data 
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function show(User $user) {
        return new UserDetailResource($user->loadMissing(['detail:id,image', 'unit:id,name']));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'unit_id' => 'required',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:3',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);  
        $validatedData['role_id'] = 2;

        $user = User::create($validatedData);
        $data = new UserResource($user);

        if($data) {
            return response()->json([
                'message' => 'success',
                'user' => $data
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function destroy($id)
    {        
        $data = User::destroy($id);

        if($data) {
            return response()->json([
                'message' => 'success',
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function statusUser(Request $request, User $user) {
        $request->validate([
            'is_active' => 'required',
        ]);

        $data = User::where('id', $user->id);

        if($request->is_active === 0) {
            $result = $data->update(['is_active' => 1]);
        } else if ($request->is_active === 1) {
            $result = $data->update(['is_active' => 0]);
        }

        if($result !== 0) {
            return response()->json([
                "message" => "Update User Status Success",
            ], 200);
        } 

        return response()->json([
            "message" => "Update User Status Failed"
        ], 400);
    }
}