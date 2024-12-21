@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Add Department</h1>

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
    <form action="{{ route('departments.store') }}" method="POST">
        @csrf
        
        <div class="form-group mb-3">
            <label for="last_name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="" required>
        </div>

        <div class="form-group mb-3">
            <label for="dob">Course</label>
            <input type="text" name="course" id="course" class="form-control" value="" required>
        </div>


        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('departments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
