<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AccountMakerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = isset($request->query()['role']) ? $request->query()['role'] : null;
        if (isset($role)) {
            if ($role == 'doctor') {
                $users = User::where('role', $role)->get();

                if (count($users) != 0) {
                    return response()->json([
                        'success' => 'true',
                        'users' => $users,
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'users' => 'No User found',
                ], 400);
            } elseif ($role == 'student') {

                $users = User::where('role', $role)->get();

                if (count($users) != 0) {
                    return response()->json([
                        'success' => 'true',
                        'users' => $users,
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'users' => 'No User found',
                ], 400);

            } elseif ($role == 'admin') {
                $users = User::where('role', $role)->get();
                if (count($users) != 0) {
                    return response()->json([
                        'success' => 'true',
                        'users' => $users,
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'users' => 'No User found',
                ], 400);

            } else {

                return response()->json([
                    'success' => 'false',
                    'message' => 'role is not exist choose (`admin` , `user` , `doctor`)',
                ], 400);

            }

        }
        return response()->json([
            'success' => 'false',
            'message' => 'The Query ' . $request->query() . ' is not correct',
        ], 400);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|between:10,20',
            'role' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create($validate);

        return response()->json([
            'success' => 'true',
            'user' => $user,
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $student = User::get()->where('role', 'student');
        return response()->json(['Absence' => $student]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
