<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="Web Logo.png">
    <title>Records</title>
    <link rel="stylesheet" href="{{ asset('/storage/css/records.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#sort_by, #sort_order, #search').on('change', function(){
                $('#sort_form').submit();
            });

            $('.toggle-collapse').click(function(){
                const target = $(this).data('target');
                $(target).collapse('toggle');
            });
        });
    </script>
    <style>
        .collapse-content {
            padding: 10px;
        }
        
    </style>
</head>
<body>

<div class="container">
    <h2>Records</h2>
    <div class="d-flex justify-content-between mb-3">
        <a href="{{('/dashboard') }}" class="btn btn-secondary">Back</a>
        <div></div>
    </div>
    <form id="sort_form" method="GET" action="{{ route('records') }}" class="form-inline mb-3">
        <input type="text" name="search" id="search" class="form-control mr-2" placeholder="Search by UserID or Document ID" value="{{ request('search') }}">
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
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groupedRecords as $key => $group)
                    @php
                        $firstRecord = $group->first();
                        $sanitizedKey = preg_replace('/[^A-Za-z0-9_\-]/', '_', $key);
                    @endphp
                    <tr>
                        <td>{{ $firstRecord->UserID }}</td>
                        <td>{{ $firstRecord->Document_ID }}</td>
                        <td>{{ $firstRecord->Subject }}</td>
                        <td>{{ $firstRecord->Date }}</td>
                        <td>
                            <a href="{{ route('documents.view', $firstRecord->FileName) }}" class="btn btn-primary" target="_self">View</a>
                            <button class="btn btn-info toggle-collapse" data-target="#collapsible-{{ $sanitizedKey }}">Track</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="p-0">
                            <div id="collapsible-{{ $sanitizedKey }}" class="collapse collapse-content">
                                <div class="container-fluid">
                                    <ul class="list-unstyled multi-steps">
                                    @foreach ($group as $index => $recipientRecord)
                                        @php
                                            // Determine the class for the dot based on the status
                                            $dotClass = '';
                                            if ($recipientRecord->status === 'approved') {
                                                $dotClass = 'is-active';
                                            } elseif ($recipientRecord->status === 'disapproved') {
                                                $dotClass = 'is-disapproved';
                                            } else {
                                                // Default to gray if status is null or not set
                                                $dotClass = 'initial-state';
                                            }
                                        @endphp
                                        <li class="{{ $dotClass }}">
                                            {{ $recipientRecord->RecipientEmail }}
                                        </li>
                                    @endforeach

                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
