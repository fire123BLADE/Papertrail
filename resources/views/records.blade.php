<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="Web Logo.png">
    <title>Records</title>
    <link rel="stylesheet" href="{{ asset('/storage/css/records.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#sort_by, #sort_order, #search').on('change', function(){
                $('#sort_form').submit();
            });
        });
    </script>
</head>
<body>

<div class="container">
    <h2>Records</h2>
    <div class="d-flex justify-content-between mb-3">
            <!-- Return button -->
            <a href="{{('/dashboard') }}" class="btn btn-secondary">Back</a>
            <div></div> <!-- Placeholder for spacing -->
        </div>
    <form id="sort_form" method="GET" action="{{ route('records') }}" class="form-inline mb-3">
        <input type="text" name="search" id="search" class="form-control mr-2" placeholder="Search by UserID or RecipientEmail" value="{{ request('search') }}">
        <select id="sort_by" name="sort_by" class="form-control mr-2">
            <option value="Date" {{ request('sort_by') == 'Date' ? 'selected' : '' }}>Date</option>
            <option value="UserID" {{ request('sort_by') == 'UserID' ? 'selected' : '' }}>UserID</option>
            <option value="Document_ID" {{ request('sort_by') == 'Document_ID' ? 'selected' : '' }}>Document ID</option>
            <option value="RecipientEmail" {{ request('sort_by') == 'RecipientEmail' ? 'selected' : '' }}>Recipient Email</option>
        </select>
        <select id="sort_order" name="sort_order" class="form-control mr-2">
            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
        </select>
    </form>
    <div class="table-responsive">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>UserID</th>
                    <th>DocumentID</th>
                    <th>Subject</th>
                    <th>Recipient</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr>
                    <td>{{ $record->UserID }}</td>
                    <td>{{ $record->Document_ID }}</td>
                    <td>{{ $record->Subject }}</td>
                    <td>{{ $record->RecipientEmail }}</td>
                    <td>{{ $record->Date }}</td>
                    <td><button class="btn btn-primary action-button">View</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
