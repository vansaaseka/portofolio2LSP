<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserDetailResource;
use App\Http\Resources\UserResource;
use App\Models\AdminCategory;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCategoryController extends Controller
{        
    public function index() {
        $users = User::where('role_id', 4)->with(['unit:id,name', 'adminCategory'])->get();

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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'admin_category_id' => 'required',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:3',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);  
        $validatedData['role_id'] = 4;

        $user = User::create($validatedData);
        $data = new UserResource($user);

        if($data) {
            return response()->json([
                'message' => 'success',
                'user' => $data,
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'nip' => 'required',
            'name' => 'required|max:255',
            'email' => [
                'required',
                'email:dns',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $userSaved = $user->save();
        
        if (!$user->detail) {
            $userDetail = new UserDetail();
            $userDetail->nip = $validatedData['nip'];
            $userDetail->user_id = $user->id;
            $userDetailSaved = $userDetail->save();
        } else {
            $userDetail = $user->userDetail;
            $userDetail->nip = $validatedData['nip'];
            $userDetailSaved = $userDetail->save();
        }
        
        if ($userSaved && $userDetailSaved) {
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

    public function categoryAdmin() {
        $categories = AdminCategory::all();

        $data = UserResource::collection($categories);

        if($data) {
            return response()->json([
                'message' => 'success',
                'categories' => $data 
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }
}