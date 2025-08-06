<!DOCTYPE html>
<html>
<head>
    <title>Add Submission</title>
</head>
<body>
    <h1>Add Submission</h1>
    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif
    <form action="/crud/submission" method="POST">
        @csrf
        <label for="submission_timestamp">Submission Timestamp:</label>
        <input type="text" id="submission_timestamp" name="submission_timestamp" value="{{ old('submission_timestamp') }}">
        @error('submission_timestamp')
            <div>{{ $message }}</div>
        @enderror
        <br>

        <label for="user_ml_output_csv_s3_uri">ML Output CSV S3 URI:</label>
        <input type="text" id="user_ml_output_csv_s3_uri" name="user_ml_output_csv_s3_uri" value="{{ old('user_ml_output_csv_s3_uri') }}">
        @error('user_ml_output_csv_s3_uri')
            <div>{{ $message }}</div>
        @enderror
        <br>

        <label for="user_ml_script_s3_uri">ML Script S3 URI:</label>
        <input type="text" id="user_ml_script_s3_uri" name="user_ml_script_s3_uri" value="{{ old('user_ml_script_s3_uri') }}">
        @error('user_ml_script_s3_uri')
            <div>{{ $message }}</div>
        @enderror
        <br>

        <label for="model_name">Model Name:</label>
        <input type="text" id="model_name" name="model_name" value="{{ old('model_name') }}">
        @error('model_name')
            <div>{{ $message }}</div>
        @enderror
        <br>

        <label for="user_name">User Name:</label>
        <input type="text" id="user_name" name="user_name" value="{{ old('user_name') }}">
        @error('user_name')
            <div>{{ $message }}</div>
        @enderror
        <br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="{{ old('email') }}">
        @error('email')
            <div>{{ $message }}</div>
        @enderror
        <br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
