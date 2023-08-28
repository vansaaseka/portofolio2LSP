<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserDetailResource;
use App\Http\Resources\UserLoginResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{    
    public function me() {
        $user = User::where('id', auth()->user()->id)->get();
        return new UserResource($user);
    }
    
    public function index() {
        $users = User::where('role_id', 3)->where('unit_id', auth()->user()->unit_id)->with(['unit:id,name', 'detail'])->get();

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

    // public function show(User $user) {
    //     return new UserDetailResource($user->loadMissing(['detail:id,image', 'unit:id,name']));
    // }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nip' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:8',
        ]);
    
        $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['unit_id'] = auth()->user()->unit_id;
        $validatedData['role_id'] = '3';
    
        $user = User::create($validatedData);
    
        if ($user) {
            // Tambahkan data ke tabel DetailUser
            $detailUser = UserDetail::create([
                'nip' => $validatedData['nip'],
                'user_id' => $user->id,
            ]);
    
            if ($detailUser) {
                $data = new UserResource($user);
    
                return response()->json([
                    'message' => 'success',
                    'user' => $data
                ], 200);
            }
        }
    
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    // public function update(Request $request, User $user)
    // {
    //     $validatedData = $request->validate([
    //         'nip' => 'required',
    //         'name' => 'required|max:255',
    //         'email' => [
    //             'required',
    //             'email:dns',
    //             Rule::unique('users')->ignore($user->id),
    //         ],
    //     ]);

    //     $user->name = $validatedData['name'];
    //     $user->email = $validatedData['email'];
    //     $userSaved = $user->save();
        
    //     if (!$user->detail) {
    //         $userDetail = new UserDetail();
    //         $userDetail->nip = $validatedData['nip'];
    //         $userDetail->user_id = $user->id;
    //         $userDetailSaved = $userDetail->save();
    //     } else {
    //         $userDetail = $user->userDetail;
    //         $userDetail->nip = $validatedData['nip'];
    //         $userDetailSaved = $userDetail->save();
    //     }
        
    //     if ($userSaved && $userDetailSaved) {
    //         return response()->json([
    //             'message' => 'success',
    //         ], 200);
    //     }
        
    //     return response()->json([
    //         'message' => 'error',
    //     ], 500);
    // }

    public function destroy($id)
    {
        // $data = User::destroy($id);
        // $userDetail = UserDetail::where('user_id', $id)->first();

        // if (!$userDetail) {
        //     return response()->json([
        //         'message' => 'UserDetail not found',
        //     ], 404);
        // }

        // $userDetail->delete();

        // if($data) {
        //     return response()->json([
        //         'message' => 'success',
        //     ], 200);
        // }
        
        // return response()->json([
        //     'message' => 'error',
        // ], 500);

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        $userDetail = UserDetail::where('user_id', $id)->first();

        if (!$userDetail) {
            return response()->json([
                'message' => 'UserDetail not found',
            ], 404);
        }

        // Hapus UserDetail
        $userDetail->delete();

        // Hapus User
        $user->delete();

        return response()->json([
            'message' => 'User and UserDetail deleted successfully',
        ], 200);
    }
}