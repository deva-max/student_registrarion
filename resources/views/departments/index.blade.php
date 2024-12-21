@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h1>Students</h1>
    <a href="{{ route('departments.create') }}" class="btn btn-primary mb-3">Add Department</a>
    <table id="departments-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#departments-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('departments.index') }}", 
            columns: [
                { data: 'name', name: 'name' },
                { data: 'course', name: 'course' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });

        $('#departments-table').on('click', '.delete-button', function(){
            const studentId = $(this).data('id');

            sweetDelete().then((result) => {
                if(result.isConfirmed){
                    const form = $('<form>',{
                        method: 'POST',
                        action: `/departments/${studentId}`
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
