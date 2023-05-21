<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'nullable',
            'phone' => 'nullable',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            $user = $request->user();

            $token = $user->createToken('authToken')->plainTextToken;
            // $query = User::query();
            // $users = $query->where('email', '=', $request->email)->with('addresses')->with('subjects')->get();
            return response()->json([
                'user' => $user->query()->where('email', $request->email)->with('addresses')->with('subjects')->get()->first(),
                'access_token' => $token,
            ]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->where('id', $request->user()->currentAccessToken()->id)->delete();
        return response()->json(['message' => 'Logged out successfully']);

    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully', 'user' => $user]);
    }
}
