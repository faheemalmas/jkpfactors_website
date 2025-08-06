@extends('layouts.admin.index')

@section('content')
    <h1 class="mb-4">CTF Data Records</h1>

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



    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Institution Affiliation</th>
                <th>WRDS Image</th>
                <th>WRDS Compustat Access Image</th>
                <th>Uploaded At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->institution_affiliation }}</td>
                    <td>
                        @if ($item->wrds_image)
                            <a href="{{ asset('storage/' . $item->wrds_image) }}" target="_blank">
                                <img src="{{ asset('storage/' . $item->wrds_image) }}" alt="WRDS Image" width="80">
                            </a>
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        @if ($item->wrds_image_access)
                            <a href="{{ asset('storage/' . $item->wrds_image_access) }}" target="_blank">
                                <img src="{{ asset('storage/' . $item->wrds_image_access) }}" alt="WRDS Compustat Image"
                                    width="80">
                            </a>
                        @else
                            No Image
                        @endif
                    </td>
                    <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $data->links() }}
    </div>
    </div>
@endsection
