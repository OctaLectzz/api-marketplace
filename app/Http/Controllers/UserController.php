<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return UserResource::collection($users);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'avatar' => 'nullable',
            'username' => 'required|string|min:6|max:20|unique:users,username',
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'role' => 'required|string|max:255',
            'phone_number' => 'nullable|string',
            'province_id' => 'nullable|integer',
            'regency_id' => 'nullable|integer',
            'district_id' => 'nullable|integer',
            'village_id' => 'nullable|integer',
            'country' => 'nullable|string',
            'zip_code' => 'nullable|integer',
            'address_one' => 'nullable',
            'address_two' => 'nullable',
            'store_name' => 'nullable|string',
            'category' => 'nullable|string',
            'store_status' => 'nullable|integer'
        ]);

        // Avatar
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '-' . $request->username . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        $user = User::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User Created Successfully',
            'data' => new UserResource($user)
        ]);
    }

    public function show(User $user)
    {
        return response()->json([
            'data' => new UserResource($user)
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'avatar' => 'nullable',
            'username' => 'required|string|min:6|max:20',
            'name' => 'required|string|max:50',
            'email' => 'required|email',
            'role' => 'required|string|max:255',
            'phone_number' => 'nullable|string',
            'province_id' => 'nullable|integer',
            'regency_id' => 'nullable|integer',
            'district_id' => 'nullable|integer',
            'village_id' => 'nullable|integer',
            'country' => 'nullable|string',
            'zip_code' => 'nullable|integer',
            'address_one' => 'nullable',
            'address_two' => 'nullable',
            'store_name' => 'nullable|string',
            'category' => 'nullable|string',
            'store_status' => 'nullable|integer'
        ]);

        // Avatar
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '-' . $user->username . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        // Username Unique
        $existingUsername = User::where('username', $data['username'])->where('id', '<>', $user->id)->first();
        if ($existingUsername) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username Already Exists',
                'data' => null
            ], 422);
        }

        // Email Unique
        $existingEmail = User::where('Email', $data['email'])->where('id', '<>', $user->id)->first();
        if ($existingEmail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email Already Exists',
                'data' => null
            ], 422);
        }

        $user->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User Edited Successfully',
            'data' => new UserResource($user)
        ]);
    }

    public function updateavatar(Request $request, User $user)
    {
        $data = $request->validate([
            'avatar' => 'required|image'
        ]);

        if ($request->hasFile('avatar')) {
            $avatarName = time() . '-' . $user->username . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        $user->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Avatar Edited Successfully',
            'data' => new UserResource($user)
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User Deleted Successfully'
        ]);
    }

    public function profile(User $user)
    {
        $user = auth()->user();

        return response()->json([
            'data' => new UserResource($user)
        ]);
    }

    public function editprofile(Request $request)
    {
        $data = $request->validate([
            'avatar' => 'nullable',
            'username' => 'required|string|min:6|max:20',
            'name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone_number' => 'nullable|string',
            'province_id' => 'nullable|integer',
            'regency_id' => 'nullable|integer',
            'district_id' => 'nullable|integer',
            'village_id' => 'nullable|integer',
            'country' => 'nullable|string',
            'zip_code' => 'nullable|integer',
            'address_one' => 'nullable',
            'address_two' => 'nullable',
            'store_name' => 'nullable|string',
            'category' => 'nullable|string',
            'store_status' => 'nullable|integer'
        ]);

        // Avatar
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '-' . auth()->user()->username . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        // Username Unique
        $existingUsername = User::where('username', $data['username'])->where('id', '<>', auth()->id())->first();
        if ($existingUsername) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username Already Exists',
                'data' => null
            ], 422);
        }

        // Email Unique
        $existingEmail = User::where('Email', $data['email'])->where('id', '<>', auth()->id())->first();
        if ($existingEmail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email Already Exists',
                'data' => null
            ], 422);
        }

        $findUser = auth()->user();
        $user = User::find($findUser->id);
        $user->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Profile Edited Successfully',
            'data' => new UserResource($user)
        ]);
    }

    public function editprofileavatar(Request $request)
    {
        $data = $request->validate([
            'avatar' => 'required|image'
        ]);

        if ($request->hasFile('avatar')) {
            $avatarName = time() . '-' . auth()->user()->username . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('avatars'), $avatarName);
            $data['avatar'] = $avatarName;
        }

        $findUser = auth()->user();
        $user = User::find($findUser->id);
        $user->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Avatar Edited Successfully',
            'data' => new UserResource($user)
        ]);
    }
}
