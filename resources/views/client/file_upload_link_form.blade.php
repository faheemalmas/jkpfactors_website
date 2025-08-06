<!DOCTYPE html>
<html>

<head>
    <title>Get File Upload Link</title>
</head>

<body>
    <h1>Get File Upload Link</h1>
    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif
    <form action="/crud/get_file_upload_link" method="GET">
        @csrf
        <label for="file_name">File Name:</label>
        <input type="text" id="file_name" name="file_name" value="{{ old('file_name') }}">
        @error('file_name')
            <div>{{ $message }}</div>
        @enderror
        <br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="{{ old('email') }}">
        @error('email')
            <div>{{ $message }}</div>
        @enderror
        <br>

        <label for="submission_timestamp">Submission Timestamp:</label>
        <input type="text" id="submission_timestamp" name="submission_timestamp"
            value="{{ old('submission_timestamp') }}">
        @error('submission_timestamp')
            <div>{{ $message }}</div>
        @enderror
        <br>

        <button type="submit">Get Link</button>
    </form>
</body>

</html>
