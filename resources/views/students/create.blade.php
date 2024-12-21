@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Add Student</h1>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to Create a New Student -->
    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="address">Address</label>
            <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="department_id">Department</label>
            <select name="dept_id" id="department_id" class="form-control" required>
                <option value="" disabled selected>Select a Department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
