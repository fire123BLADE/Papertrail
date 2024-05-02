<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="{{ asset('storage/photos/Web Logo.png') }}">
    <link rel="stylesheet" href="{{ asset('storage/css/Dashboard.css') }}">
    <title>Dashboard</title>
</head>
<body>
    <header>
        <div class="notification-icon">
            <a href="{{ url('Notification.php') }}">
                <img src="{{ asset('storage/photos/notification.svg') }}" alt="notification-icon" class="icon">
            </a>
            <div class="profile-icon">
                <span class="user-name">User</span>
                <img src="{{ asset('storage/photos/user.png') }}" alt="profile-icon" class="icon">
            </div>
        </div>
    </header>
    <nav>
         <a href="a" class="logo">
                    <img src="{{ asset('storage/photos/slidebar-logo-new-negate.png') }}" alt="logo" class="icon">
                </a>
        <ul>
           
            <li>
                <a href="#Link-Dashboard">
                    <img src="{{ asset('storage/photos/dashboard.png') }}" alt="dashboard-icon" class="icon">
                    <span class="nav-item">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ url('Submit.php') }}">
                    <img src="{{ asset('storage/photos/sent.svg') }}" alt="sent-icon" class="icon">
                    <span class="nav-item">Submit</span>
                </a>
            </li>
            <li>
                <a href="{{ url('Records.php') }}">
                    <img src="{{ asset('storage/photos/history.svg') }}" alt="history-icon" class="icon">
                    <span class="nav-item">Records</span>
                </a>
            </li>
            <li>
                <a href="{{ url('Archive.php') }}">
                    <img src="{{ asset('storage/photos/archive.png') }}" alt="archive-icon" class="icon">
                    <span class="nav-item">Archive</span>
                </a>
            </li>
        
        </ul>
        <a href="{{ url('Login.php') }}" class="Out">
                    <img src="{{ asset('storage/photos/logout.png') }}" alt="logout-icon" class="icon">
                    <span class="nav-item">Log Out</span>
                </a>
    </nav>
    <h2>Dashboard</h2>
    <div id="Link-Dashboard" class="content">
        <div class="dashboard">
            <h1>Welcome to PaperTrail<br></h1>
            <p>PaperTrail is your comprehensive document tracker. It's designed to help you manage, sent and monitor all your important documents efficiently.</p>
            <p>With PaperTrail, you can easily track the status of documents, monitor their progress through approval, and ensure the document privacy.</p>
            <p>Whether you're managing contracts, proposals, or any other important documents, Our system provides you with the tools you need to stay organized and in control.</p>
            <p>Get started today and experience the convenience and efficiency of Our System!</p>
        </div>
    </div>
</body>
</html>
