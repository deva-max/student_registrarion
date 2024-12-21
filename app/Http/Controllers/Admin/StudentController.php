<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\Students;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $students = Students::with('department')->get(); 

            return DataTables::of($students)
                ->addColumn('department_name', function ($student) {
                    return $student->department->name; 
                })
                ->addColumn('actions', function ($student) {
                    
                    return '
                        <a href="' . route('students.edit', $student->id) . '" class="btn btn-primary btn-sm">Edit</a>
                        <button type="button" class="btn btn-danger btn-sm delete-button" data-id="' . $student->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['actions']) // Ensure HTML in the actions column is rendered
                ->make(true);
        }

        return view('students.index'); // Return the view for normal requests
    }

     // Show the form for creating a new student.
     public function create()
     {
        $departments = Departments::all(); // Fetch all departments
        return view('students.create', compact('departments'));
     }
 
     // Store a newly created student in storage.
     public function store(Request $request)
     {
         $request->validate([
             'first_name' => 'required|string|max:255',
             'last_name' => 'required|string|max:255',
             'dob' => 'required|date',
             'address' => 'required|string',
             'dept_id' => 'required|exists:departments,id',
         ]);
 
         Students::create($request->all());
 
         return redirect()->route('students.index')->with('success', 'Student created successfully.');
     }
 
     // Display the specified student.
     public function show($id)
     {
         $student = Students::findOrFail($id);
         return view('students.show', compact('student'));
     }
 
     // Show the form for editing the specified student.
     public function edit($id)
     {
         $student = Students::with('department')->findOrFail($id);
         $departments = Departments::get();
         return view('students.edit', compact('student','departments'));
     }
 
     // Update the specified student in storage.
     public function update(Request $request, $id)
     {
         $request->validate([
             'first_name' => 'sometimes|string|max:255',
             'last_name' => 'sometimes|string|max:255',
             'dob' => 'sometimes|date',
             'address' => 'sometimes|string',
             'dept_id' => 'sometimes|exists:departments,id',
         ]);
 
         $student = Students::findOrFail($id);
         $student->update($request->all());
 
         return redirect()->route('students.index')->with('success', 'Student updated successfully.');
     }
 
     // Remove the specified student from storage.
     public function destroy($id)
     {
         $student = Students::findOrFail($id);
         $student->delete();
 
         return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
     }
}
