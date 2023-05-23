<?php

namespace App\Http\Controllers;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'subject_name' => 'string|required',
            'subject_code' => 'string|nullable|unique:subjects,subject_code',
            'subject_deprt' => 'string|required',
            'require_subject' => 'string|required',
            'grade' => 'required',
        ]);

        if ($validate) {
            $subject = Subject::create($validate);
            return response()->json([
                'success' => true,
                'subject' => $subject,
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => [
                'error' => 'One of subject parameters is not found',
            ],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $request->query();
        $subject = Subject::where('grade', (int) $request->query()['grade'])->get();

        if (count($subject) != 0) {
            return response()->json([
                'succss' => 'true',
                'result' => $subject,
            ]);
        }
        return response()->json([
            'succss' => 'false',
            'message' => ['error' => 'No subject Found'],
        ], 400);
    }
    public function showAllSubjects(Request $request){
        $limit = isset($request->query()['limit']) ? $request->query()['limit'] : 1;
        $subjects = Subject::paginate($limit);
        return response()->json([
            'succss' => 'true',
            'result' => $subjects,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'subject_name' => 'nullable|min:5',
            'subject_code' => 'nullable|between:2,5',
            'subject_deprt' => 'nullable|max:2',
            'grade' => 'integer|between:1,4|nullable',
            'require_subject' => 'nullable',
        ]);
        $subject = Subject::find($id);
        if (isset($subject) && $validate) {
            if (isset($request->subject_name)) {
                $subject['subject_name'] = $request->subject_name;
            }
            if (isset($request->subject_code)) {
                $subject['subject_code'] = $request->subject_code;
            }
            if (isset($request->subject_deprt)) {
                $subject['subject_deprt'] = $request->subject_deprt;
            }
            if (isset($request->grade)) {
                $subject['grade'] = $request->grade;
            }
            if (isset($request->require_subject)) {
                $subject['require_subject'] = $request->require_subject;
            }
            $subject->save();
            return response()->json([
                'success' => true,
                'message' => 'updated successfully',
                'data' => $subject,
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'No Subject found',

        ], 400);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::find($id);
        if (isset($subject)) {
            $subject->delete();
            return response()->json([
                'success' => true,
                'message' => 'Deleted Successfully',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Subject is not found',
        ], 400);
    }
}
