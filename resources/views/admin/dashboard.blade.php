@extends('layouts.admin.index')

@section('content')
    <section>
        <div class="container">
            <form id="bulkDeleteForm" method="POST" action="{{ route('tasks.bulkDelete') }}">
                @csrf
                @method('DELETE')

                <div class="d-flex justify-content-between align-items-center">
                    <h1>Contact us Messages List</h1>
                    <button type="submit" class="btn btn-danger mb-3">Delete Selected</button>
                </div>

                <table class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Message</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contact as $task)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $task->id }}">
                                </td>
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->first_name }}</td>
                                <td>{{ $task->last_name }}</td>
                                <td>{{ $task->email }}</td>
                                <td>{{ $task->message }}</td>
                                <td>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </section>
    {{-- <section>
        <div class="container">
            <h1>Contact us Messages List</h1>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email Address</th>
                        <th>Message</th>
                        <th>Delete</th>
                        <th>Dataset</th>
                        <th>Difficulty</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contact as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->first_name }}</td>
                            <td>{{ $task->last_name }}</td>
                            <td>{{ $task->email }}</td>
                            <td>{{ $task->message }}</td>
                            <td>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>

                            <td>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                            <td>{{ $task->dataset }}</td>
                            <td>{{ $task->difficulty }}</td>
                            <td>
                            <a href="#" class="btn btn-info">View</a>
                            <a href="#" class="btn btn-primary">Edit</a>
                            <a href="{{ Storage::url($task->file_path) }}" class="btn btn-secondary" download>Download
                                    File</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section> --}}
@endsection

@section('page-js')
    <script>
        document.getElementById('select-all').addEventListener('click', function(e) {
            const checkboxes = document.querySelectorAll('input[name="ids[]"]');
            checkboxes.forEach(checkbox => checkbox.checked = e.target.checked);
        });
    </script>
@endsection
