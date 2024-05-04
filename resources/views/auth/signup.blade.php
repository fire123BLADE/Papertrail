<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="storage/photos/Web Logo.png">
    <title>Sign Up</title>
    <link rel="stylesheet" href="{{ asset('storage/css/Login.css') }}">
</head>
<body>
    <header class="header"> 
        <img src="storage/photos/Web Logo.png" alt="logo" width="120" height="120">
        <span class="logo-text" style="font-size: 5rem; font-family: Monaco, monospace">PaperTrail</span>
    </header>
    <div class="signup">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h2>Sign Up</h2>
        <form method="POST" action="{{ route('signup') }}">
            @csrf
            <input class="input-field" type="text" placeholder="First Name" name="FirstName" required><br>
            <input class="input-field" type="text" placeholder="Last Name" name="LastName" required><br>
            <input class="input-field" type="text" placeholder="Username" name="username" required><br>
            <input class="input-field" type="email" placeholder="Email" name="email" required><br>
            <input class="input-field" type="password" placeholder="Password" name="password" required><br>
            <select name="department" id="department">
                <option value="OSA">Office of Student Affairs (OSA)</option>
                <option value="DEAN">Dean</option>
                <option value="SAO">Student Accounting Office (SAO)</option>
                <option value="STUDENT">Student</option>
                <option value="Employee">Employee</option>
            </select><br>
            <button type="submit">Register</button>
        </form>
        <button><a href="{{ route('login') }}">Login</a></button>
    </div>
    
</body>
</html>
