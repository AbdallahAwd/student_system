<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function create(Request $request)
    {
        $valid = $request->validate([
            'name' => 'required',
            'code' => 'required|max:2',
        ]);

        if ($valid) {
            $depart = Department::create([
                'name' => $request->name,
                'code' => strtoupper($request->code),
            ]);

            return response()->json([
                'success' => true,
                'department' => $depart,
            ], 201);

        }
        return response()->json(['success' => false, 'message' => 'Provide correct params please'], 400);
    }

    public function deleteDepartment($id)
    {
        $department = Department::find($id);

        if (isset($department)) {
            $department->delete();
            return response()->json([
                'success' => true,
                'message' => 'Deleted Successfully',
            ], 200);
        }
        return response()->json([
            'success' => true,
            'message' => 'Department Not Found',
        ], 200);

    }
    public function getDepartments()
    {

        $departments = Department::all();

        return response()->json([
            'data' => $departments,
        ]);

    }
    public function searchDepartment($id)
    {

        $departments = Department::find($id);

        if (isset($departments)) {
            return response()->json([
                'data' => $departments,
            ]);

        }
        return response()->json([
            'success' => false,
            'message' => 'Department Not Found',
        ], 400);

    }
}
