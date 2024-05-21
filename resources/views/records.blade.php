<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="Web Logo.png">
    <title>Records</title>
    <link rel="stylesheet" href="{{ asset('/storage/css/records.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>Records</h2>
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
