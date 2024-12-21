@extends('layouts.app')

@section('content')


<div class="container mt-5">
    <h1>Students</h1>
    <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Add Student</a>
    <table id="students-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>DOB</th>
                <th>Address</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#students-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('students.index') }}", 
            columns: [
                { data: 'first_name', name: 'first_name' },
                { data: 'last_name', name: 'last_name' },
                { data: 'dob', name: 'dob' },
                { data: 'address', name: 'address' },
                { data: 'department_name', name: 'department.name' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });

        $('#students-table').on('click', '.delete-button', function(){
            const studentId = $(this).data('id');

            sweetDelete().then((result) => {
                if(result.isConfirmed){
                    const form = $('<form>',{
                        method: 'POST',
                        action: `/students/${studentId}`
                    });

                    form.append($('<input>', {
                        type: 'hidden',
                        name: '_token',
                        value: '{{ csrf_token() }}'
                    }));

                    form.append($('<input>', {
                        type: 'hidden',
                        name: '_method',
                        value: 'DELETE'
                    }));

                    $('body').append(form);
                    form.submit();
                }
            });
        });
    });


</script>
@endsection
