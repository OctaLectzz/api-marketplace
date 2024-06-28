<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'avatar' => 'nullable',
            'username' => 'required|string|min:6|max:20|unique:users,username',
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
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

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $token =  $user->createToken('marketplace')->plainTextToken;
        $data = [
            'token' => $token,
            'user' => new UserResource($user)
        ];

        Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Register Successfully',
            'data' => $data
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('email', $request->email)->first();
            $success['token'] =  $user->createToken('marketplace')->plainTextToken;
            $success['user'] =  new UserResource($user);

            return response()->json([
                'status' => 'success',
                'message' => 'Login Successfully',
                'data' => $success
            ]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Email or Password Failed, Please try again later'
            ], 403);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout Successfully'
        ]);
    }
}
