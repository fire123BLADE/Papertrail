<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="{{ asset('storage/css/index.css') }}">
</head>
<body>
    <div class="container">
        <h1>Welcome to Paper Trail</h1>
        <p>A document-tracking system</p>
        <p>Tracks your document with ease and precision</p>
        <div class="form-container">

            <a href="{{ route('login') }}" class="login-button">Login as Admin/User</a>
        </div>
    </div>
</body>
</html>
