@extends('layouts.admin.index')

@section('content')
    <div class="container">
        <h2>Update Admin Email & Password</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.update') }}" method="POST">
            @csrf

            <input type="hidden" name="id" value="{{ $admin->id }}">

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="form-control" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label>New Password (leave blank to keep unchanged)</label>
                <input type="password" name="password" class="form-control">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <button class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
