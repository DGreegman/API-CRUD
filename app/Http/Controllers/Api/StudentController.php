<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
        
        $students = Student::all();
       
        if ($students->count() > 0) {
            
            return response()->json([
                'status' => 200,
                'students' => $students
            ], 200);
        }else{

            return response()->json([
            'status' => 404,
            'students' => 'No Records Found'
        ], 404);
        }

    }

    public function store(Request $request) {
        
        $validatore = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:11',
        ]);

        if ($validatore->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validatore->messages()
            ], 422);
        } else {
            $students = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone
            ]);
            if($students){
                return response()->json([
                    'status' => 200,
                    'message' => 'Student Created Successfully'
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Ooops... Something Went Wrong'
                ], 500);
            }
        }
        
    }

    public function show($id) {

        $students = Student::find($id);

        if ($students) {
            return response()->json([
                'status' => 200,
                'message' => $students
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Such Student Found!'
            ], 404);
        }
        
    }
    public function edit($id) {

        $students = Student::find($id);

        if ($students) {
            return response()->json([
                'status' => 200,
                'message' => $students
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Such Student Found!'
            ], 404);
        }
        
    }

    public function update(Request $request, int $id) {
        $validatore = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:11',
        ]);

        if ($validatore->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validatore->messages()
            ], 422);
        } else {

            $students = Student::find($id);

            if($students){
                $students->update([
                    'name' => $request->name,
                    'course' => $request->course,
                    'email' => $request->email,
                    'phone' => $request->phone
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Student Updated Successfully'
                ], 200);

            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'No Such Student Found'
                ], 404);
            }
        }
    }

    public function destroy($id) {
        
        $students = Student::find($id);

        if($students){
            $students->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Student Deleted Successfully...'
            ], 200);

        }else{
            return response()->json([
                'status'=> 404,
                'message' => 'Ooops...): No Such Student Exits...'
            ], 404);
        }
    }
}
