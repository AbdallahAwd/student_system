<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\addresses;
use App\Models\User;
use App\Models\UserSub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create(Request $request)
    {
        // validate
        $user = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|between:10,20|unique:users,phone',
            'role' => 'required|string',
            'grade' => 'nullable',
            'password' => 'required|string|confirmed|min:8',
            'address' => 'required',
            'subjects' => 'required|array',

        ]);

        $subjects = $user['subjects'];

        // encrypt Password
        $user['password'] = Hash::make($user['password']);
        // Create New Address
        $new_user = User::create($user);
        //Add Address to user
        $user['address']['user_id'] = $new_user->id;
        addresses::create($user['address']);
        // New subjects
        foreach ($subjects as $subject) {
            $subject['user_id'] = $new_user->id;
            UserSub::create($subject);

        }
        // create new token
        $token = $new_user->createToken('authToken')->plainTextToken;
        // Attach Subjects to User
        // $new_user->subjects()->attach($user['subjects']);

        return response()->json([
            'user' => $new_user->query()->where('email', $new_user->email)->with('addresses')->with('subjects')->get(),
            'access_token' => $token,
        ], 201);

    }
}
