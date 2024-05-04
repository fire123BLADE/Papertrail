<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('storage/css/Login.css') }}">
</head>
<body>
<header class="header"> 
        <img src="storage/photos/Web Logo.png" alt="logo" width="120" height="120">
        <span class="logo-text" style="font-size: 5rem; font-family: Monaco, monospace">PaperTrail</span>
    </header>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class = "user">
            <label for="Username">Username</label>
            <input class= "input-field" id="Username" type="text" name="username" required autofocus>
        
            <label for="Password">Password</label>
            <input class= "input-field" id="Password" type="password" name="password" autocomplete = "off" required>

            <button type="submit">Login</button>
            <button><a href="{{ route('signup') }}">Sign Up</a></button>
        </div>
        
        
    </form>
    @if ($errors->any())
    <div id="errorMessage" class="alert alert-danger">
        {{ $errors->first() }}
    </div>
    <script>
        //hide error message after 3 seconds
        setTimeout(function () {
            document.getElementById('errorMessage').style.display = 'none';
        }, 3000);
    </script>
    @endif
</body>
</html>