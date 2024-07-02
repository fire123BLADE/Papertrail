<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="image/x-icon" href="Web Logo.png">
    <link rel="stylesheet" href="{{ asset('storage/css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-NV+zBq/FVtCNCNOIElUI2QG2YI8kK7B+3+3fZtlBt/C/oi2It+zW8DBXeBRf3HIsDs9UVckO5JG1jx23FrrOgA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dashboard</title>
</head>
<body>
    <header>
        <div class="notification-icon">
            <a href="Notification.php" class="icon-link" id="notification-btn">
                <img src="{{ asset('storage/photos/notification.svg') }}" alt="notification-icon" class="icon">
                <span class="badge">3</span>
            </a>
            <div class="profile-icon">
                <span class="user-name">User</span>
                <img src="{{ asset('storage/photos/user.png') }}" alt="profile-icon" class="profile-icon-img">
            </div>
        </div>
        <div class="hamburger-menu">
            <i class="fas fa-bars"></i>
        </div>
    </header>
    <nav id="sidebar">
        <ul>
            <li>
                <a href="#" class="logo">
                    <img src="{{ asset('storage/photos/slidebar-logo-new-negate.png') }}" alt="logo" class="icon">
                </a>
            </li>
            <li>
                <a href="{{ route('submitAnnouncement') }}">
                    <img src="{{ asset('storage/photos/sent.svg') }}" alt="sent-icon" class="icon">
                    <span class="nav-item">Announcement</span>
                </a>
            </li>
            <li>
                <a href="{{ asset('records') }}">
                    <img src="{{ asset('storage/photos/history.svg') }}" alt="history-icon" class="icon">
                    <span class="nav-item">View Records</span>
                </a>
            </li>
            <li>
                <a href="{{ route('login') }}" class="Out">
                    <img src="{{ asset('storage/photos/logout.png') }}" alt="logout-icon" class="icon">
                    <span class="nav-item">Log Out</span>
                </a>
            </li>
        </ul>
    </nav>
    