<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateController extends Controller
{
    public function updateUser(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        if ($validatedData) {
            if (isset($validatedData['name'])) {
                $user->name = $validatedData['name'];
            }

            if (isset($validatedData['email'])) {
                $user->email = $validatedData['email'];
            }

            $user->save();

            return response()->json(['message' => 'User updated successfully']);

        }
        return response()->json(['success' => false, 'message' => 'Can not update unknown fields'], 401);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'old_password' => 'required|min:8',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['error' => 'The old password is incorrect.'], 401);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }

    public function search(Request $request)
    {
        $query = User::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->has('email') || $request->has('name')) {

            if (!$request->has('role')) {

                return response()->json(['success' => false, 'message' => '`role` param is required'], 400);
            }
            $users = $query->where('role', '=', $request->role)->with('addresses')->get();

            return response()->json(['users' => $users]);
        }
        $users = $query->with('addresses')->with('subjects')->get();
        return response()->json(['users' => $users]);

    }

    public function userInfo(Request $request, $id)
    {
        $user = User::query()->where('id', $id)->with('address')->with('subjects')->get();
        if ($user) {
            return response()->json(['user' => $user->first()]);
        }
        return response()->json(
            ['success' => false,
                'message' => 'User Not Found'], 400);

    }

}
