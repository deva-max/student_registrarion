<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $departments = Departments::get();
            return datatables()->of($departments)
                ->addColumn('actions', function ($row) {
                    return '<a href="' . route('departments.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                    <button type="button" class="btn btn-danger btn-sm delete-button" data-id="' . $row->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('departments.index');
    }


    // Show the form for creating a new department.
    public function create()
    {
        return view('departments.create');
    }

    // Store a newly created department in storage.
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments',
            'course' => 'required|string|max:255'
        ]);

        Departments::create($request->all());

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    // Display the specified department.
    public function show($id)
    {
        $department = Departments::findOrFail($id);
        return view('departments.show', compact('department'));
    }

    // Show the form for editing the specified department.
    public function edit($id)
    {
        $department = Departments::findOrFail($id);
        return view('departments.edit', compact('department'));
    }

   
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255|unique:departments,name,' . $id,
            'course' => 'sometimes|string|max:255|unique:departments,course,' . $id
        ]);

        $department = Departments::findOrFail($id);
        $department->update($request->all());

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    // Remove the specified department from storage.
    public function destroy($id)
    {
        $department = Departments::findOrFail($id);
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
