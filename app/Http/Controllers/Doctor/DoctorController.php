<?php

namespace App\Http\Controllers\Doctor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSub;




class DoctorController extends Controller
{

    
    public function getSubs(Request $request)
    {

        if (!$request->has('id')) {
            return response()->json([
                'success' => false,
                'message' => 'Missing parameter: id',
            ], 400);
        }
        $query = UserSub::query();
        $user = $query->where('user_id', $request->id)->with('pdf')->get();
        return response()->json([
            'success' => true,
            'subjects' => $user,
        ], 200);

    }
}