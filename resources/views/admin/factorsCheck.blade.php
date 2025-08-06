@extends('layouts.admin.index')

@section('content')
    <h1>Admin Panel: File Uploads</h1>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Optional: Display API response for debugging -->
    @if (session('api_response'))
        <div class="alert alert-info">
            <strong>API Response:</strong> {{ json_encode(session('api_response')) }}
        </div>
    @endif

    <table class="table table-striped">
        <thead class="thead-light">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Model Name</th>
                <th>CSV File</th>
                <th>Code File</th>
                <th>PDF File</th>
                <th>Send Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($uploads as $upload)
                <tr>
                    <td>{{ $upload->username }}</td>
                    <td>{{ $upload->email }}</td>
                    <td>{{ $upload->model_name }}</td>
                    <td>
                        <a href="{{ $upload->csv_file_path }}" target="_blank" download>Download CSV</a>
                    </td>
                    <td>
                        @if ($upload->python_file_path)
                            @php
                                $fileExtension = pathinfo($upload->python_file_path, PATHINFO_EXTENSION);
                                $downloadText = $fileExtension === 'r' ? 'Download R Script' : 'Download Python Script';
                            @endphp
                            <a href="{{ $upload->python_file_path }}" target="_blank" download>{{ $downloadText }}</a>
                        @else
                            <span class="text-muted">No Code File</span>
                        @endif
                    </td>
                    <td>
                        @if ($upload->pdf_file_path)
                            <a href="{{ $upload->pdf_file_path }}" target="_blank" download>Download PDF</a>
                        @else
                            <span class="text-muted">No PDF</span>
                        @endif
                    </td>
                    {{-- <td>
                        <a href="{{ $upload->python_file_path }}" target="_blank" download>Download Python Script</a>
                    </td> --}}
                    {{-- <td>
                        <a href="{{ route('admin.downloadCsv', $upload->id) }}">Download CSV</a>
                    </td>
                    <td>
                        <a href="{{ route('admin.downloadPy', $upload->id) }}">Download Python Script</a>
                    </td> --}}
                    <td>{{ $upload->send_status }}</td>
                    <td>
                        <form action="{{ route('admin.submitAndExecute', $upload->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary">Submit and Execute</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
