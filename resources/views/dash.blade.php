<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/photos/Web Logo.png') }}">
    <link rel="stylesheet" href="{{ asset('storage/css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-NV+zBq/FVtCNCNOIElUI2QG2YI8kK7B+3+3fZtlBt/C/oi2It+zW8DBXeBRf3HIsDs9UVckO5JG1jx23FrrOgA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dashboard</title>
</head>
<body>
    <header>
        <div class="notification-icon">
            <a href="{{ url('Notification.php') }}" class="icon-link" id="notification-btn">
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
                <a href="#Link-Dashboard">
                    <img src="{{ asset('storage/photos/dashboard.png') }}" alt="dashboard-icon" class="icon">
                    <span class="nav-item">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('submitDocument') }}">
                    <img src="{{ asset('storage/photos/sent.svg') }}" alt="sent-icon" class="icon">
                    <span class="nav-item">Submit</span>
                </a>
            </li>
            <li class = "hide-records">
                <a href="{{ asset('records') }}">
                    <img src="{{ asset('storage/photos/history.svg') }}" alt="history-icon" class="icon">
                    <span class="nav-item">Records</span>
                </a>
            </li>
            <li>
                <a href="{{ route('archive') }}">
                    <img src="{{ asset('storage/photos/archive.png') }}" alt="archive-icon" class="icon">
                    <span class="nav-item">Archive</span>
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
    <div class="overlay"></div>
    <div id="content">
        <h2>Dashboard</h2>
        <div id="Link-Dashboard" class="content">
            <div class="quick-stats">
                <div class="stat">
                    <h4>Total Documents Sent</h4>
                    <p>{{ $totalDocuments }}</p>

                </div>
                <div class="stat">
                    <h4>Pending Approval</h4>
                    <p>{{ $pendingDocuments }}</p>
                </div>
                <div class="stat">
                    <h4>Approved</h4>
                    <p>{{ $approvedDocuments }}</p>
                </div>
                <div class="stat">
                    <h4>Archived</h4>
                    <p>{{ $archivedDocuments }}</p>
                </div>
            </div>
            <div class="content-section">
                <h3>Recent Activity</h3>
                <ul>
                @foreach($recentDocuments as $document)
            <li>
                Document ID {{ $document->Document_ID }} 
                @if ($document->status) was
                    {{ $document->status }}
                @else
                     is pending
                @endif
                @if ($document->status && $document->Date)
                    on {{ $document->Date->format('Y-m-d H:i:s') }}
                @elseif (!$document->status)
                    {{-- Do nothing --}}
                @else
                    on N/A
                @endif
            </li>
        @endforeach
                </ul>
            </div>
            <div class="content-section">
                <h3>Upcoming Deadlines</h3>
                <ul>
                    <li>Document ID 33445566778 needs approval by 03/10</li>
                    <li>Submit annual report by 03/15</li>
                </ul>
            </div>
            <div class="content-section charts">
                <h3>Document Status Overview</h3>
                <canvas id="statusChart" class="small-chart"></canvas>
            </div>
            <div class="content-section user-tips">
                <h3>Tips & Tricks</h3>
                <ul>
                    <li>Regularly check the status of your documents to ensure timely approvals.</li>
                    <li>Use the search functionality to quickly find specific documents.</li>
                    <li>Archive documents you no longer need to keep your workspace organized.</li>
                </ul>
            </div>
            <div class="content-section quick-actions">
                <h3>Quick Actions</h3>
                <button class="btn btn-primary" onclick="location.href='{{ route('submitDocument') }}';">Submit New Document</button>
                <button class="btn btn-tertiary" onclick="location.href='{{ route('archive') }}';">Access Archive</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('storage/js/Dashboard.js') }}"></script>
    <script>
        // Chart.js example
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('statusChart').getContext('2d');
            var statusChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Approved', 'Archived'],
                    datasets: [{
                        label: 'Document Status',
                        data: [{{ $pendingDocuments }},
                        {{ $approvedDocuments }}, {{ $archivedDocuments}}],
                        backgroundColor: ['#f1c40f', '#2ecc71', '#e74c3c']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Document Status Overview'
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
